;(function(window, QB) {
    'use strict';

    /** GLOBAL */
    window.webapp = {};
    webapp.helpers = {};
    webapp.filter = {
        'names': 'no _1977 inkwell moon nashville slumber toaster walden'
    };
    webapp.network = {};


    /* [getQueryVar get value of key from search string of url]
     * @param  {[string]} q [name of query]
     * @return {[string]}   [value of query]
     */
    webapp.helpers.getQueryVar = function(q){
        var query = window.location.search.substring(1),
            vars = query.split('&'),
            answ = false;

        vars.forEach(function(el, i){
            var pair = el.split('=');

            if(pair[0] === q) {
                answ = pair[1];
            }
        });

        return answ;
    };

    webapp.helpers.isBytesReceivedChanges = function(userId, inboundrtp) {
        var res = true,
            inbBytesRec = inboundrtp ? inboundrtp.bytesReceived : 0;

        if(!webapp.network[userId]) {
            webapp.network[userId] = {
              'bytesReceived': inbBytesRec
            };
        } else {
            if(webapp.network[userId].bytesReceived >= inbBytesRec) {
                res = false;
            } else {
                webapp.network[userId] = {
                    'bytesReceived': inbBytesRec
                };
            }
        }

        return res;
    };

    /**
     * [Set fixed of relative position on footer]
     */
    webapp.helpers.setFooterPosition = function() {
        var $footer = $('.j-footer'),
            invisibleClassName = 'invisible',
            footerFixedClassName = 'footer-fixed';

        if( $(window).outerHeight() > $('.j-wrapper').outerHeight() ) {
          $footer.addClass(footerFixedClassName);
        } else {
          $footer.removeClass(footerFixedClassName);
        }

        $footer.removeClass(invisibleClassName);
    };

    webapp.helpers.notifyIfUserLeaveCall = function(session, userId, reason, title) {
        var userRequest = _.findWhere(webapp.users, {'id': +userId}),
            userCurrent = _.findWhere(webapp.users, {'id': +session.currentUserID});

        /** It's for p2p call */
        if(session.opponentsIDs.length === 1) {
            webapp.helpers.stateBoard.update({
                'title': 'p2p_call_stop',
                'property': {
                    'name': userRequest.full_name,
                    'currentName': userCurrent.full_name,
                    'reason': reason
                }
            });
        } else {
            /** It's for groups call */
            $('.j-callee_status_' + userId).text(title);
        }
    };

    webapp.helpers.changeFilter = function(selector, filterName) {
        $(selector).removeClass(webapp.filter.names)
            .addClass( filterName );
    };

    webapp.helpers.getConStateName = function(num) {
        var answ;

        switch (num) {
            case QB.webrtc.PeerConnectionState.DISCONNECTED:
            case QB.webrtc.PeerConnectionState.FAILED:
            case QB.webrtc.PeerConnectionState.CLOSED:
                answ = 'DISCONNECTED';
                break;
            default:
                answ = 'CONNECTING';
        }

        return answ;
    };

    webapp.helpers.toggleRemoteVideoView = function(userId, action) {
      var $video = $('#remote_video_' + userId);

      if(!_.isEmpty(webapp.currentSession) && $video.length){
          if(action === 'show') {
              $video.parents('.j-callee').removeClass('wait');
          } else if(action === 'hide') {
              $video.parents('.j-callee').addClass('wait');
          } else if(action === 'clear') {
              /** detachMediaStream take videoElementId */
              webapp.currentSession.detachMediaStream('remote_video_' + userId);
              $video.removeClass('wait');
          }
        }
    };

    /**
     * [getUui - generate a unique id]
     * @return {[string]} [a unique id]
     */
    function _getUui() {
        var navigator_info = window.navigator;
        var screen_info = window.screen;
        var uid = navigator_info.mimeTypes.length;

        uid += navigator_info.userAgent.replace(/\D+/g, '');
        uid += navigator_info.plugins.length;
        uid += screen_info.height || '';
        uid += screen_info.width || '';
        uid += screen_info.pixelDepth || '';

        return uid;
    }

    webapp.developer='';
    webapp.helpers.join = function(data) {
        //alert(JSON.stringify(data));
        webapp.developer = data.developer;
        var userRequiredParams = {
            'login': _getUui(),
            'password': 'webAppPass'
        };

        return new Promise(function(resolve, reject) {
            QB.createSession(function(csErr, csRes){
                if(csErr) {
                    reject(csErr);
                } else {
                    /** In first trying to login */
                    QB.login(userRequiredParams, function(loginErr, loginUser){
                        if(loginErr) {
                            /** Login failed, trying to create account */
                            QB.users.create({
                                'login': _getUui(),
                                'password': 'webAppPass',
                                'full_name': data.username,
                                'tag_list': data.room
                            }, function(createErr, createUser){
                                if(createErr) {
                                    console.log('[create user] Error:', createErr);
                                    reject(createErr);
                                } else {
                                    QB.login(userRequiredParams, function(reloginErr, reloginUser) {
                                        if(reloginErr) {
                                            console.log('[relogin user] Error:', reloginErr);
                                        } else {
                                            resolve(reloginUser);
                                        }
                                    });
                                }
                            });
                        } else {
                            /** Update info */
                            if(loginUser.user_tags !== data.room || loginUser.full_name !== data.username ) {
                                QB.users.update(loginUser.id, {
                                    'full_name': data.username,
                                    'tag_list': data.room
                                }, function(updateError, updateUser) {
                                    if(updateError) {
                                        console.log('APP [update user] Error:', updateError);
                                        reject(updateError);
                                    } else {
                                        resolve(updateUser);
                                    }
                                });
                            } else {
                                resolve(loginUser);
                            }
                        }
                    });
                }
            });
        });
    };

    webapp.helpers.renderUsers = function() { 
        return new Promise(function(resolve, reject) {
            var tpl = _.template( $('#user_tpl').html() ),
                usersHTML = '',
                users = [];
                
                //alert(webapp.developer);
                //alert(webapp.caller.user_tags);

                QB.users.get({'tags':[webapp.caller.user_tags],'full_name':''+[webapp.developer]+'','per_page':1}, function(err, result){               

                webapp.isAvailable = result.total_entries;
                });
                
                setTimeout(function(){
               // call to developer
               //alert(webapp.isAvailable);
               if(webapp.isAvailable==1){
               //connect to developer
               QB.users.get({'tags':[webapp.caller.user_tags],'full_name':''+[webapp.developer]+'','per_page':1}, function(err, result){
                if (err) {
                    reject(err);
                } else {
                    _.each(result.items, function(item) {
                        users.push(item.user);

                        if( item.user.id !== webapp.caller.id ) {
                            usersHTML += tpl(item.user);
                        }
                    });

                    if(result.items.length < 1) {
                        reject({
                            'title': 'not found',
                            'message': 'Not found users by tag'
                        });
                    } else {
                        resolve({
                            'usersHTML': usersHTML,
                            'users': users
                        });
                    }
                }
                 
            });
               }
               else{
                 // connect to admin  
                 QB.users.get({'tags':'biggdeal','full_name':'support', 'per_page': 1}, function(err, result){
                if (err) {
                    reject(err);
                } else {
                    _.each(result.items, function(item) {
                        users.push(item.user);

                        if( item.user.id !== webapp.caller.id ) {
                            usersHTML += tpl(item.user);
                        }
                    });

                    if(result.items.length < 1) {
                        reject({
                            'title': 'not found',
                            'message': 'Not found users by tag'
                        });
                    } else {
                        resolve({
                            'usersHTML': usersHTML,
                            'users': users
                        });
                    }
                }
                 
            });  
               }
            
        
        
                },4000);

           
           
        });
    };
}(window, window.QB));
