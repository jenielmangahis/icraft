;(function(window, QB,webapp, CONFIG, $, Backbone) {
    'use strict';

    $(function() {
        var sounds = {
            'call': 'callingSignal',
            'end': 'endCallSignal',
            'rington': 'ringtoneSignal'
        };

        var recorder = null;
        var recorderOpts = {
                callbacks: {
                    onStartRecording: function onStartRecord() {
                        console.log('[QB Recorder] onStartRecording');
                        $('.j-record').addClass('active');
                    },
                    onStopRecording: function(blob) {
                        console.log('[QB Recorder] onStopRecording');
                        $('.j-record').removeClass('active');

                        var down = confirm('Do you want to download video?');
                        if(down) {
                            recorder.download(blob, 'QB_WEBrtc_sample' + Date.now());
                        }

                        recorder = null;
                    },
                    onErrorRecording: function(error) {
                        console.error('Recorder error', error);
                    }
                }
            };

        var ui = {
            'income_call': '#income_call',
            'filterSelect': '.j-filter',
            'sourceFilter': '.j-source',
            'insertOccupants': function() {
                var $occupantsCont = $('.j-users');

                function cb($cont, res) {
                    $cont.empty()
                        .append(res)
                        .removeClass('wait');
                }

                return new Promise(function(resolve, reject) {
                    $occupantsCont.addClass('wait');

                    webapp.helpers.renderUsers().then(function(res) {
                        cb($occupantsCont, res.usersHTML);
                        resolve(res.users);
                    }, function(error) {
                        cb($occupantsCont, error.message);
                        reject('Not found users by tag');
                    });
                });
            }
        };

        var call = {
            callTime: 0,
            callTimer: null,
            updTimer: function() {
                this.callTime += 1000;

                $('#timer').removeClass('invisible')
                    .text( new Date(this.callTime).toUTCString().split(/ /)[4] );
              }
        };

        var remoteStreamCounter = 0;

        function closeConn(userId) {
            if(recorder) {
                recorder.stop()
            }
            webapp.helpers.notifyIfUserLeaveCall(webapp.currentSession, userId, 'disconnected', 'Disconnected');
            webapp.currentSession.closeConnection(userId);
        }

        var ffHack = {
            waitingReconnectTimer: null,
            waitingReconnectTimeoutCallback: function(userId, cb) {
                console.info('Start waitingReconnectTimeoutCallback for Firefox');

                clearTimeout(this.waitingReconnectTimer);
                cb(userId);
            },
            isFirefox: navigator.userAgent.toLowerCase().indexOf('firefox') > -1
        };

        var Router = Backbone.Router.extend({
            'routes': {
                'join': 'join',
                'dashboard': 'dashboard',
                '*query': 'relocated'
            },
            'container': $('.page'),
            'relocated': function() {
                var path = webapp.caller ? 'dashboard' : 'join';

                webapp.router.navigate(path, {'trigger': true});
            },
            'join': function() {
                /** Before use WebRTC checking WebRTC is avaible */
                if (!QB.webrtc) {
                    alert('Error: ' + CONFIG.MESSAGES.webrtc_not_avaible);
                    return;
                }

                if (!_.isEmpty(webapp.caller)) {
                    webapp.router.navigate('dashboard');
                    return false;
                }

                this.container
                    .removeClass('page-dashboard')
                    .addClass('page-join');

                webapp.helpers.setFooterPosition();

                webapp.caller = {};
                webapp.callees = {};
                webapp.calleesAnwered = [];
                webapp.users = [];
            },
            'dashboard': function() {
                if(_.isEmpty(webapp.caller)) {
                    webapp.router.navigate('join', { 'trigger': true });
                    return false;
                }

                /** render page */
                this.container
                    .removeClass('page-join')
                    .addClass('page-dashboard')
                    .find('.j-dashboard').empty();

                /** render skelet */
                $('.j-dashboard').append( $('#dashboard_tpl').html() );

                /** render stateBoard */
                webapp.helpers.stateBoard = new webapp.helpers.StateBoard('.j-state_board', {
                    title: 'tpl_default',
                    property: {
                        'tag': webapp.caller.user_tags,
                        'name':  webapp.caller.full_name,
                    }
                });

                /** render users wrwebapper */
                $('.j-users_wrap').append( $('#users_tpl').html() );
                ui.insertOccupants().then(function(users) {
                    webapp.users = users;
                }, function(err) {
                    console.warn(err);
                });

                /** render frames */
                var framesTpl =  _.template( $('#frames_tpl').html() );
                $('.j-board').append( framesTpl({'nameUser': webapp.caller.full_name}));

                QB.webrtc.getMediaDevices('videoinput').then(function(devices) {
                    if(devices.length > 1) {
                        var $select = $(ui.sourceFilter);

                        for (var i = 0; i !== devices.length; ++i) {
                            var deviceInfo = devices[i],
                                option = document.createElement('option');

                            option.value = deviceInfo.deviceId;

                            if (deviceInfo.kind === 'videoinput') {
                                option.text = deviceInfo.label || 'Camera ' + (i + 1);
                                $select.append(option);
                            }
                        }

                        $select.removeClass('invisible');
                    }
                }).catch(function(error) {
                    console.warn('getMediaDevices', error);
                });

                webapp.helpers.setFooterPosition();
            }
        });

        /**
         * INIT
         */
        var CREDS = webapp.helpers.getQueryVar('creds') === 'test' ? CONFIG.CREDENTIALS.test : CONFIG.CREDENTIALS.prod;

        QB.init(
            CREDS.appId,
            CREDS.authKey,
            CREDS.authSecret,
            CONFIG.APP_CONFIG
        );

        var statesPeerConn = _.invert(QB.webrtc.PeerConnectionState);

        webapp.router = new Router();
        Backbone.history.start();

        /**
         * JOIN
         */
        $(document).on('submit','.j-join', function() {
            var $form = $(this),
                data = _.object( _.map( $form.serializeArray(), function(item) {
                    return [item.name, item.value.trim()];
                }));

            if(localStorage.getItem('isAuth')) {
                $('#already_auth').modal();
                return false;
            }

            $form.addClass('join-wait');

            webapp.helpers.join(data).then(function (user) {
                webapp.caller = user;

                QB.chat.connect({
                    jid: QB.chat.helpers.getUserJid( webapp.caller.id, CREDS.appId ),
                    password: 'webAppPass'
                }, function(err, res) {
                    console.log(JSON.stringify(err));
                    
                    if(err) {
                        if(!_.isEmpty(webapp.currentSession)) {
                            webapp.currentSession.stop({});
                            webapp.currentSession = {};
                        }

                        webapp.helpers.changeFilter('#localVideo', 'no');
                        webapp.helpers.changeFilter('#main_video', 'no');
                        webapp.mainVideo = 0;

                        $(ui.filterSelect).val('no');
                        webapp.calleesAnwered = [];

                        if(call.callTimer) {
                            $('#timer').addClass('invisible');
                            clearInterval(call.callTimer);
                            call.callTimer = null;
                            call.callTime = 0;
                            webapp.helpers.network = {};
                        }
                    } else {
                        $form.removeClass('join-wait');
                        $form.trigger('reset');
                        localStorage.setItem('isAuth', true);
                        webapp.router.navigate('dashboard', { trigger: true });
                    }
                });
            }).catch(function(error) {
                console.error(error);
            });

            return false;
        });

        /**
         * DASHBOARD
         */
        /** REFRESH USERS */
        $(document).on('click', '.j-users__refresh', function() {
            var $btn = $(this);

            webapp.callees = {};
            $btn.prop('disabled', true);

            ui.insertOccupants().then(function(users) {
                webapp.users = users;

                $btn.prop('disabled', false);
                webapp.helpers.setFooterPosition();
            }, function() {
                $btn.prop('disabled', false);
                webapp.helpers.setFooterPosition();
            });
        });

        /** Check / uncheck user (callee) */
        $(document).on('click', '.j-user', function() {
            var $user = $(this),
                user = {
                    id: +$.trim( $user.data('id') ),
                    name: $.trim( $user.data('name') )
                };

            if( $user.hasClass('active') ) {
                delete webapp.callees[user.id];
                $user.removeClass('active');
            } else {
                webapp.callees[user.id] = user.name;
                $user.addClass('active');
            }
        });

        /** Call / End of call */
        $(document).on('click', '.j-actions', function() {
            var $btn = $(this),
                $videoSourceFilter = $(ui.sourceFilter),
                videoElems = '',
                mediaParams = {
                    'audio': true,
                    'video': {
                        deviceId: $videoSourceFilter.val() ? $videoSourceFilter.val() : undefined
                    },
                    'options': {
                        'muted': true,
                        'mirror': true
                    },
                    'elemId': 'localVideo'
                };

            /** Hangup */
            if ($btn.hasClass('hangup')) {
                if(!_.isEmpty(webapp.currentSession)) {

                    if(recorder) {
                        recorder.stop();
                    }

                    webapp.currentSession.stop({});
                    webapp.currentSession = {};

                    webapp.helpers.stateBoard.update({
                        'title': 'tpl_default',
                        'property': {
                            'tag': webapp.caller.user_tags,
                            'name':  webapp.caller.full_name,
                        }
                    });

                    webapp.helpers.setFooterPosition();

                    return false;
                }
            } else {
                /** Check internet connection */
                if(!window.navigator.onLine) {
                    webapp.helpers.stateBoard.update({'title': 'no_internet', 'isError': 'qb-error'});
                    return false;
                }

                /** Check callee */
                if(_.isEmpty(webapp.callees)) {
                    $('#error_no_calles').modal();
                    return false;
                }

                webapp.helpers.stateBoard.update({'title': 'create_session'});
                webapp.currentSession = QB.webrtc.createNewSession(Object.keys(webapp.callees), QB.webrtc.CallType.VIDEO);

                webapp.currentSession.getUserMedia(mediaParams, function(err, stream) {
                    if (err || !stream.getAudioTracks().length || !stream.getVideoTracks().length) {
                        var errorMsg = '';

                        webapp.currentSession.stop({});

                        webapp.helpers.stateBoard.update({
                            'title': 'tpl_device_not_found',
                            'isError': 'qb-error',
                            'property': {
                                'name': webapp.caller.full_name
                            }
                        });
                    } else {
                        webapp.currentSession.call({}, function(error) {
                            if(error) {
                                console.warn(error.detail);
                            } else {
                                var compiled = _.template( $('#callee_video').html() );

                                webapp.helpers.stateBoard.update({'title': 'calling'});

                                document.getElementById(sounds.call).play();

                                Object.keys(webapp.callees).forEach(function(id, i, arr) {
                                    videoElems += compiled({
                                        'userID': id,
                                        'name': webapp.callees[id],
                                        'state': 'connecting'
                                    });
                                });

                                $('.j-callees').append(videoElems);

                                $videoSourceFilter.attr('disabled', true);
                                $btn.addClass('hangup');
                                webapp.helpers.setFooterPosition();
                            }
                        });
                    }
                });
            }
        });

        /** DECLINE */
        $(document).on('click', '.j-decline', function() {
            if (!_.isEmpty(webapp.currentSession)) {
                webapp.currentSession.reject({});

                $(ui.income_call).modal('hide');
                document.getElementById(sounds.rington).pause();
            }
        });

        /** ACCEPT */
        $(document).on('click', '.j-accept', function() {
            var $videoSourceFilter = $(ui.sourceFilter),
                mediaParams = {
                    audio: true,
                    video: {
                        optional: [
                            {sourceId: $videoSourceFilter.val() ? $videoSourceFilter.val() : undefined}
                        ]
                    },
                    elemId: 'localVideo',
                    options: {
                        muted: true,
                        mirror: true
                    }
                },
                videoElems = '';

            $(ui.income_call).modal('hide');
            document.getElementById(sounds.rington).pause();

            webapp.currentSession.getUserMedia(mediaParams, function(err, stream) {
                if (err || !stream.getAudioTracks().length || !stream.getVideoTracks().length) {
                    var errorMsg = '';

                    webapp.currentSession.stop({});

                    if(err && err.message) {
                        errorMsg += 'Error: ' + err.message;
                    } else {
                        errorMsg += 'tpl_device_not_found';
                    }

                    webapp.helpers.stateBoard.update({
                        'title': errorMsg,
                        'isError': 'qb-error'
                    });
                } else {
                    var opponents = [webapp.currentSession.initiatorID],
                        compiled = _.template( $('#callee_video').html() );

                    $('.j-actions').addClass('hangup');
                    $(ui.sourceFilter).attr('disabled', true);

                    /** get all opponents */
                    webapp.currentSession.opponentsIDs.forEach(function(userID, i, arr) {
                        if(userID != webapp.currentSession.currentUserID){
                            opponents.push(userID);
                        }
                    });

                    opponents.forEach(function(userID, i, arr) {
                        var peerState = webapp.currentSession.connectionStateForUser(userID),
                            userInfo = _.findWhere(webapp.users, {'id': +userID});

                        if( (document.getElementById('remote_video_' + userID) === null) ) {
                            videoElems += compiled({
                                'userID': userID,
                                'name': userInfo.full_name,
                                'state': webapp.helpers.getConStateName(peerState)
                            });

                            if(peerState === QB.webrtc.PeerConnectionState.CLOSED){
                                webapp.helpers.toggleRemoteVideoView(userID, 'clear');
                            }
                        }
                    });

                    $('.j-callees').append(videoElems);
                    webapp.helpers.stateBoard.update({
                        'title': 'tpl_during_call',
                        'property': {
                            'name': webapp.caller.full_name
                        }
                    });
                    webapp.helpers.setFooterPosition();
                    webapp.currentSession.accept({});
                }
            });
        });

        /** CHANGE FILTER */
        $(document).on('change', ui.filterSelect, function() {
            var filterName = $.trim( $(this).val() );

            webapp.helpers.changeFilter('#localVideo', filterName);

            if(!_.isEmpty(webapp.currentSession)) {
                webapp.currentSession.update({'filter': filterName});
            }
        });

        $(document).on('click', '.j-callees__callee__video', function() {
            var $that = $(this),
                userId = +($(this).data('user')),
                activeClass = [];

            if( webapp.currentSession.peerConnections[userId].stream && !_.isEmpty( $that.attr('src')) ) {
                if( $that.hasClass('active') ) {
                    $that.removeClass('active');

                    webapp.currentSession.detachMediaStream('main_video');
                    webapp.helpers.changeFilter('#main_video', 'no');
                    webapp.mainVideo = 0;
                    remoteStreamCounter = 0;
                } else {
                    $('.j-callees__callee_video').removeClass('active');
                    $that.addClass('active');

                    webapp.helpers.changeFilter('#main_video', 'no');

                    activeClass = _.intersection($that.attr('class').split(/\s+/), webapp.filter.names.split(/\s+/) );

                    /** set filter to main video if exist */
                    if(activeClass.length) {
                        webapp.helpers.changeFilter('#main_video', activeClass[0]);
                    }
                    webapp.currentSession.attachMediaStream('main_video', webapp.currentSession.peerConnections[userId].stream);
                    webapp.mainVideo = userId;
                }
            }
        });

        $(document).on('click', '.j-caller__ctrl', function() {
           var $btn = $(this),
               isActive = $btn.hasClass('active');

           if( _.isEmpty( webapp.currentSession)) {
               return false;
           } else {
               if(isActive) {
                   $btn.removeClass('active');
                   webapp.currentSession.unmute( $btn.data('target') );
               } else {
                   $btn.addClass('active');
                   webapp.currentSession.mute( $btn.data('target') );
               }
           }
        });
        
        /** Video recording */
        $(document).on('click', '.j-record', function() {
            var $btn = $(this),
                isActive = $btn.hasClass('active');

            if(_.isEmpty(webapp.currentSession)) {
                return false;
            } else if(QB.Recorder.isAvailable()) {
                if(!isActive){
                    var connections = webapp.currentSession.peerConnections,
                        connection = connections[webapp.mainVideo],
                        connectionsCount = Object.keys(connections).length;

                    if (!connection || connectionsCount !== 1){
                        return false;
                    }

                    recorder = new QB.Recorder(connection.stream, recorderOpts);
                    recorder.start();
                } else {
                    recorder.stop();
                }
            }
        });

        /** LOGOUT */
        $(document).on('click', '.j-logout', function() {
            QB.users.delete(webapp.caller.id, function(err, user){
                if (user) {
                    webapp.caller = {};
                    webapp.users = [];

                    QB.chat.disconnect();
                    localStorage.removeItem('isAuth');
                    //webapp.router.navigate('join', {'trigger': true});
                    //webapp.helpers.setFooterPosition();
                    window.open('', '_self', ''); window.close();
                } else  {
                    console.error('Logout failed:', err);
                }
            });
        });

        /** Close tab or browser */
        $( window ).unload(function() {
            localStorage.removeItem('isAuth');
        });

        /**
         * QB Event listener.
         *
         * [Recommendation]
         * We recomend use Function Declaration
         * that SDK could identify what function(listener) has error
         *
         * Chat:
         * - onDisconnectedListener
         * WebRTC:
         * - onCallListener
         * - onCallStatsReport
         * - onUpdateCallListener
         * 
         * - onAcceptCallListener
         * - onRejectCallListener
         * - onUserNotAnswerListener
         * 
         * - onRemoteStreamListener
         * 
         * - onStopCallListener
         * - onSessionCloseListener
         * - onSessionConnectionStateChangedListener
         */

        QB.chat.onDisconnectedListener = function() {
            console.log('onDisconnectedListener.');
        };

        QB.webrtc.onCallStatsReport = function onCallStatsReport(session, userId, stats, error) {
            console.group('onCallStatsReport');
                console.log('userId: ', userId);
                console.log('session: ', session);
                console.log('stats: ', stats);
            console.groupEnd();

            /**
             * Hack for Firefox
             * (https://bugzilla.mozilla.org/show_bug.cgi?id=852665)
             */
            if(ffHack.isFirefox) {
                var inboundrtp = _.findWhere(stats, {'type': 'inboundrtp'}),
                    webrtcConf = CONFIG.APP_CONFIG.webrtc,
                    timeout = (webrtcConf.disconnectTimeInterval - webrtcConf.statsReportTimeInterval) * 1000;

                if(!webapp.helpers.isBytesReceivedChanges(userId, inboundrtp)) {
                    console.warn('This is Firefox and user ' + userId + ' has lost his connection.');

                    if(recorder) {
                        recorder.pause();
                    }
                    
                    webapp.helpers.toggleRemoteVideoView(userId, 'hide');
                    $('.j-callee_status_' + userId).text('disconnected');

                    if(!_.isEmpty(webapp.currentSession) && !ffHack.waitingReconnectTimer) {
                        ffHack.waitingReconnectTimer = setTimeout(ffHack.waitingReconnectTimeoutCallback, timeout, userId, closeConn);
                    }
                } else {
                    if(recorder) {
                        recorder.resume();
                    }
                    
                    if(ffHack.waitingReconnectTimer) {
                        clearTimeout(ffHack.waitingReconnectTimer);
                        ffHack.waitingReconnectTimer = null;
                        console.info('clearTimeout(ffHack.waitingReconnectTimer)');
                    }

                    webapp.helpers.toggleRemoteVideoView(userId, 'show');
                    $('.j-callee_status_' + userId).text('connected');
                }
            }
        };

        QB.webrtc.onSessionCloseListener = function onSessionCloseListener(session){
            console.log('onSessionCloseListener: ', session);

            document.getElementById(sounds.call).pause();
            document.getElementById(sounds.end).play();

            $('.j-actions').removeClass('hangup');
            $('.j-caller__ctrl').removeClass('active');
            $(ui.sourceFilter).attr('disabled', false);
            $('.j-callees').empty();

            if(!ffHack.isFirefox && recorder) {
                recorder.stop();
            }

            webapp.currentSession.detachMediaStream('main_video');
            webapp.currentSession.detachMediaStream('localVideo');
            remoteStreamCounter = 0;

            if(session.opponentsIDs.length > 1) {
                webapp.helpers.stateBoard.update({
                    'title': 'tpl_call_stop',
                    'property': {
                        'name': webapp.caller.full_name
                    }
                });
            } else {
                webapp.helpers.notifyIfUserLeaveCall(session, session.opponentsIDs[0], 'closed');
            }
        };

        QB.webrtc.onUserNotAnswerListener = function onUserNotAnswerListener(session, userId) {
            console.group('onUserNotAnswerListener.');
                console.log('UserId: ', userId);
                console.log('Session: ', session);
            console.groupEnd();

            var opponent = _.findWhere(webapp.users, {'id': +userId});

            /** It's for p2p call */
            if(session.opponentsIDs.length === 1) {
                webapp.helpers.stateBoard.update({
                    'title': 'p2p_call_stop',
                    'property': {
                        'name': opponent.full_name,
                        'currentName': webapp.caller.full_name,
                        'reason': 'not answered'
                    }
                });
            } else {
                $('.j-callee_status_' + userId).text('No Answer');
            }
        };

        QB.webrtc.onCallListener = function onCallListener(session, extension) {
            console.group('onCallListener.');
                console.log('Session: ', session);
                console.log('Extension: ', extension);
            console.groupEnd();

            webapp.currentSession = session;

            ui.insertOccupants().then(function(users) {
                webapp.users = users;
                var initiator = _.findWhere(webapp.users, {id: session.initiatorID});

                /** close previous modal */
                $(ui.income_call).modal('hide');

                $('.j-ic_initiator').text(initiator.full_name);

                // check the current session state
                if(webapp.currentSession.state !== QB.webrtc.SessionConnectionState.CLOSED){
                    $(ui.income_call).modal('show');
                    document.getElementById(sounds.rington).play();
                }
            });
        };

        QB.webrtc.onRejectCallListener = function onRejectCallListener(session, userId, extension) {
            console.group('onRejectCallListener.');
                console.log('UserId: ' + userId);
                console.log('Session: ' + session);
                console.log('Extension: ' + JSON.stringify(extension));
            console.groupEnd();

            var user = _.findWhere(webapp.users, {'id': +userId}),
                userCurrent = _.findWhere(webapp.users, {'id': +session.currentUserID});

            /** It's for p2p call */
            if(session.opponentsIDs.length === 1) {
                webapp.helpers.stateBoard.update({
                    'title': 'p2p_call_stop',
                    'property': {
                        'name': user.full_name,
                        'currentName': userCurrent.full_name,
                        'reason': 'rejected the call'
                    }
                });
            } else {
                $('.j-callee_status_' + userId).text('Rejected');
            }
        };

        QB.webrtc.onStopCallListener = function onStopCallListener(session, userId, extension) {
            console.group('onStopCallListener.');
                console.log('UserId: ', userId);
                console.log('Session: ', session);
                console.log('Extension: ', extension);
            console.groupEnd();

            webapp.helpers.notifyIfUserLeaveCall(session, userId, 'hung up the call', 'Hung Up');

            if(recorder) {
                recorder.stop();
            }
        };

        QB.webrtc.onAcceptCallListener = function onAcceptCallListener(session, userId, extension) {
            console.group('onAcceptCallListener.');
                console.log('UserId: ', userId);
                console.log('Session: ', session);
                console.log('Extension: ', extension);
            console.groupEnd();

            var userInfo = _.findWhere(webapp.users, {'id': +userId}),
                filterName = $.trim( $(ui.filterSelect).val() );

            document.getElementById(sounds.call).pause();
            webapp.currentSession.update({'filter': filterName});

            /** update list of callee who take call */
            webapp.calleesAnwered.push(userInfo);

            if(webapp.currentSession.currentUserID === webapp.currentSession.initiatorID) {
                webapp.helpers.stateBoard.update({
                    'title': 'tpl_accept_call',
                    'property': {
                        'users': webapp.calleesAnwered
                    }
                });
            }
        };

        QB.webrtc.onRemoteStreamListener = function onRemoteStreamListener(session, userId, stream) {
            console.group('onRemoteStreamListener.');
                console.log('userId: ', userId);
                console.log('Session: ', session);
                console.log('Stream: ', stream);
            console.groupEnd();

            var state = webapp.currentSession.connectionStateForUser(userId),
                peerConnList = QB.webrtc.PeerConnectionState;

            if(state === peerConnList.DISCONNECTED || state === peerConnList.FAILED || state === peerConnList.CLOSED) {
                return false;
            }

            webapp.currentSession.peerConnections[userId].stream = stream;
            webapp.currentSession.attachMediaStream('remote_video_' + userId, stream);

            if( remoteStreamCounter === 0) {
                $('#remote_video_' + userId).click();

                webapp.mainVideo = userId;
                ++remoteStreamCounter;
            }

            if(!call.callTimer) {
                call.callTimer = setInterval( function(){ call.updTimer.call(call); }, 1000);
            }
        };

        QB.webrtc.onUpdateCallListener = function onUpdateCallListener(session, userId, extension) {
            console.group('onUpdateCallListener.');
                console.log('UserId: ' + userId);
                console.log('Session: ' + session);
                console.log('Extension: ' + JSON.stringify(extension));
            console.groupEnd();

            webapp.helpers.changeFilter('#remote_video_' + userId, extension.filter);

            if (+(webapp.mainVideo) === userId) {
                webapp.helpers.changeFilter('#main_video', extension.filter);
            }
        };

        QB.webrtc.onSessionConnectionStateChangedListener = function onSessionConnectionStateChangedListener(session, userId, connectionState) {
            console.group('onSessionConnectionStateChangedListener.');
                console.log('UserID:', userId);
                console.log('Session:', session);
                console.log('Сonnection state:', connectionState, statesPeerConn[connectionState]);
            console.groupEnd();

           var connectionStateName = _.invert(QB.webrtc.SessionConnectionState)[connectionState],
               $calleeStatus = $('.j-callee_status_' + userId),
               isCallEnded = false;

           if(connectionState === QB.webrtc.SessionConnectionState.CONNECTING) {
               $calleeStatus.text(connectionStateName);
           }

           if(connectionState === QB.webrtc.SessionConnectionState.CONNECTED) {
               webapp.helpers.toggleRemoteVideoView(userId, 'show');
               $calleeStatus.text(connectionStateName);
           }

           if(connectionState === QB.webrtc.SessionConnectionState.COMPLETED) {
               webapp.helpers.toggleRemoteVideoView(userId, 'show');
               $calleeStatus.text('connected');
           }

           if(connectionState === QB.webrtc.SessionConnectionState.DISCONNECTED) {
               webapp.helpers.toggleRemoteVideoView(userId, 'hide');
               $calleeStatus.text('disconnected');
           }

           if(connectionState === QB.webrtc.SessionConnectionState.CLOSED){
               webapp.helpers.toggleRemoteVideoView(userId, 'clear');

               if(webapp.mainVideo === userId) {
                   $('#remote_video_' + userId).removeClass('active');

                   webapp.helpers.changeFilter('#main_video', 'no');
                   webapp.mainVideo = 0;
               }

               if( !_.isEmpty(webapp.currentSession) ) {
                   if ( Object.keys(webapp.currentSession.peerConnections).length === 1 || userId === webapp.currentSession.initiatorID) {
                       $(ui.income_call).modal('hide');
                       document.getElementById(sounds.rington).pause();
                   }
               }

               isCallEnded = _.every(webapp.currentSession.peerConnections, function(i) {
                   return i.iceConnectionState === 'closed';
               });

               /** remove filters */
               if( isCallEnded ) {
                   webapp.helpers.changeFilter('#localVideo', 'no');
                   webapp.helpers.changeFilter('#main_video', 'no');
                   $(ui.filterSelect).val('no');

                   webapp.calleesAnwered = [];
               }

                if (webapp.currentSession.currentUserID === webapp.currentSession.initiatorID && !isCallEnded) {
                   /** get array if users without user who ends call */
                    webapp.calleesAnwered = _.reject(webapp.calleesAnwered, function(num){ return num.id === +userId; });

                    webapp.helpers.stateBoard.update({
                       'title': 'tpl_accept_call',
                       'property': {
                           'users': webapp.calleesAnwered
                        }
                    });
                }

                if( _.isEmpty(webapp.currentSession) || isCallEnded ) {
                    if(call.callTimer) {
                        $('#timer').addClass('invisible');
                        clearInterval(call.callTimer);
                        call.callTimer = null;
                        call.callTime = 0;
                        webapp.helpers.network = {};
                    }
                }
           } 
         };
    });
}(window, window.QB, window.webapp, window.CONFIG,  jQuery, Backbone));
