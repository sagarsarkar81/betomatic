<?php


Route::get('/','LandingPageController@index');
Route::get('/login','LandingPageController@index');
Route::post('/CheckUserName','LandingPageController@check_username');
Route::post('/getCountryCode','LandingPageController@GetCountryCode');
Route::post('/checkUserEmailId','LandingPageController@check_email');
Route::post('/CheckPhoneNumber','LandingPageController@check_phoneNumber');
Route::post('/getRegister','RegistrationController@getRegister');
Route::get('/account-activation/{id}','RegistrationController@accountActivation');
Route::post('/getlogindata','RegistrationController@getLogin');
Route::get('/home','RegistrationController@userHomePage');
Route::get('/logout','RegistrationController@logout');
Route::post('/forgot-pass-mail','RegistrationController@forgotPassMail');
Route::get('/service','LandingPageController@service');
Route::get('/about-us','LandingPageController@about_us');
Route::get('/contact','LandingPageController@contact');
Route::get('/faq','LandingPageController@faq');
Route::get('/change-password','RegistrationController@change_password');
Route::post('/change-password-data','RegistrationController@change_password_data');
//*********newsfeed start*******//
Route::post('/search-username','NewsFeedController@SearchByUsername');
Route::post('/display-block','NewsFeedController@DisplayBlockArray');
Route::post('/check-newsfeed-likes','NewsFeedController@CheckNewsFeedLikes');
Route::post('/get-like-value','NewsFeedController@GetLikeValue');
Route::post('/news-feed-post','NewsFeedController@NewsFeedPostDetails');
Route::post('/news-feed-comment','NewsFeedController@NewsFeedCommentDetails');
Route::post('/see-all-comments','NewsFeedController@SeeAllComments');
Route::post('/bet-slip-copy','NewsFeedController@BetSlipCopy');
Route::post('/count-copy','NewsFeedController@CountCopy');
Route::post('/Check-betslip-existance','NewsFeedController@CheckBetSlipExistance');
Route::post('/display-block-responsive','NewsFeedController@DisplayBlockArrayResponsive');
Route::post('/get-poeple-likes','NewsFeedController@GetPeoplesLikeDetails');
Route::post('/news-feed-comments-like','NewsFeedController@GetNewsFeedCommentsLike');
Route::post('/get-reply-against-comment','NewsFeedController@GetReplyAgainstComment');
Route::post('/get-like-against-comment','NewsFeedController@GetLikeDetailsAgainstComment');
Route::post('/my-bet-privacy-settings','NewsFeedController@MyBetPrivacySettings');
Route::post('/get-privacy-data','NewsFeedController@GetPrivacyData');
Route::post('/display-comment-modal','NewsFeedController@DisplayOldComment');
Route::post('/submit-edit-comment','NewsFeedController@SubmitEditComment');
Route::post('/delete-comment','NewsFeedController@DeleteComment');
Route::post('/display-reply-modal','NewsFeedController@DisplayOldReply');
Route::post('/submit-edit-reply','NewsFeedController@SubmitEditReply');
Route::post('/delete-reply','NewsFeedController@DeleteReply');
/********************************/
/********search all*****************/
Route::get('/search-view-all/{username}','NewsFeedController@SearchViewAll');
Route::get('/visit-user-profile/{user_id}','NewsFeedController@VisitUserProfile');
Route::get('/view-user-profile/{user_id}','NewsFeedController@VisitUserProfile');
/**********************************/
//******profile*********//
Route::get('/profile','ProfileController@index');
Route::get('/edit-profile','EditProfileController@index');
Route::post('/update-profile','EditProfileController@updateProfile');
Route::post('/Change-email-from-profile','EditProfileController@ChangeEmailFromProfile');
Route::post('/edit-settings-form','EditProfileController@EditSettingsFormSubmit');
Route::get('/activation/{id}','EditProfileController@accountActivation');
Route::post('/update-bio','EditProfileController@UpdateBio');

//-----------follow and following------------------//
Route::get('/follow-following','ProfileController@FollowFollowing');
Route::get('/follow-following/{IncidentId}','ProfileController@FollowFollowingNotification');
Route::post('/Follwing-User','ProfileController@FollowingUser');
Route::get('/visitors-follow-following/{user_id}','ProfileController@VisitorsFollowFollowing');
//---------------------------------------------------------------------//
//------------------Favourite Sports---------------------------------//
Route::post('/favourite-sports','ProfileController@UpdateFavouriteSports');
Route::post('/favourite-team-player','ProfileController@UpdateFavouriteTeamPlayer');
//--------------------------------------------------------------------//
//-----------------------Album---------------------------------------//
Route::post('/Upload-album','ProfileController@UploadAlbum');
Route::post('/submit-album-data','ProfileController@SubmitAlbumData');
Route::post('/submit-album-data2','ProfileController@SubmitAlbumData2');
Route::post('/Edit-album-name','ProfileController@EditAlbumName');
Route::post('/Delete-album','ProfileController@DeleteAlbum');
//----------------------------------------------------------------------//
//Route::post('/preregdata','LandingPageController@PreRegistration');
//Route::get('register', ['uses'=>'RegistrationController@Register','as'=>'Register']);
/*****test purpose********************/
//Route::get('/test-upload','testing@index');
//Route::get('/post-upload','testing@postUpload');
Route::get('/testing','testing@TestingGuzzle');
//Route::get('/testing','testing@TestingGuzzle');
//****************************************************//
Route::get('/Test-Page','EditProfileController@TestPage');
Route::post('/post-upload','EditProfileController@test_upload');
/***************************************/
/******LeaderBoard******/
Route::get('/leaderboard','LeaderBoardController@Leaderboard');
Route::get('/get-all-leaderboard-data','LeaderBoardController@GetAllLeaderBoardData');
Route::post('/get-leaderboard-data-daywise','LeaderBoardController@GetLeaderBoardDataDayWise');
/************************/
/**********Report Abuse********/
Route::post('/submit-report','NewsFeedController@SubmitReportAbuse');
/******************************/
/**************Left bar link up**************/
//Route::get('/all-sports','RegistrationController@AllSports');
Route::get('/all-sports','BetFairController\SportsTypesController@getSportsTypes');
/*********************************************/
/***********odds page*******************/
Route::get('/soccer-odds','SoccerOddsController@index');
Route::post('/soccer-league-list','SoccerOddsController@SoccerLeagueList');
Route::post('/soccer-odds-listing-page','SoccerOddsController@SoccerOddsListing');
Route::post('/scroll-league-list','SoccerOddsController@ScrollLeagueListLoad');
Route::get('/soccer-odds-listing-page','SoccerOddsController@SoccerOddsListing');
Route::post('/CheckOdds','SoccerOddsController@CheckOddsDetails');
//Route::post('/Remove-Odds-From-Session','SoccerOddsController@RemoveOddsFromSession');
//Route::post('/Stake-Value','SoccerOddsController@InputStakeValue');
//Route::post('/Place-Bet','SoccerOddsController@BetPlaceData');
Route::get('/soccer-odds-testing','SoccerOddsController@SoccerOddsTesting');
Route::get('/remove-total-betslip','SoccerOddsController@RemoveTotalBetslip');
Route::post('/stake-accu-session','SoccerOddsController@StakeAccumulatorInSession');
Route::post('/Place-Accumulator-Bet','SoccerOddsController@PlaceAccumulatorBet');
//Route::get('/single-bet-info','SoccerOddsController@SingleBetInfo');
//Route::get('/accumulator-bet-info','SoccerOddsController@AccumulatorBetInfo');
Route::post('/check-minimum-stake','SoccerOddsController@CheckMinimumStake');
Route::post('/minimum-combination','SoccerOddsController@MinimumCombination');
//Route::get('/set-featured-match','SoccerOddsController@SetFeaturedMatch');
/*****accumulator*********/
Route::post('/check-accumulator-odds','SoccerOddsController@CheckAccumulatorOdds');
Route::post('/check-same-matchId','SoccerOddsController@CheckSameMatchId');
/***************************************/
/**************Notification*************/
Route::get('/get-notifications','NotificationController@ReadNotification');
Route::get('/get-detail-notification','NotificationController@GetDetailNotificationList');
Route::get('/visit-notification-detail','NotificationController@VisitNotificationDetails');
Route::get('/visit-news-feed-page/{IncidentId}','NotificationController@VisitNewsFeedPageSelectedNotification');
/***************************************/
/******************Academy*********************/
Route::get('/academy','AcademyController@AcademyPage');
Route::get('/travelodge-school','AcademyController@Academy2ndTab');
Route::get('/bonus-trading','AcademyController@Academy3rdTab');
/**********************************************/
/****************Trending****************/
Route::get('/trending','TrendingController@TrendingPage');
Route::get('/Get-Post-Story','TrendingController@GetPostStory');
Route::get('/Get-Replied-Comments','TrendingController@GetRepliedComments');
Route::post('/Trending-Post','TrendingController@TrendingPost');
Route::post('/Post-Story','TrendingController@PostStory');
Route::post('/reply-form-submit','TrendingController@ReplyFormSubmit');
Route::post('/Likes-Trending-Post','TrendingController@LikesTrendingPost');
Route::post('/DisLike-Trending-Post','TrendingController@DisLikeTrendingPost');
Route::post('/Search-by-keyword-trending','TrendingController@SearchByKeywordTrending');
Route::post('/Search-by-user-choice','TrendingController@SearchByUserChoice');
Route::post('/Social-Share-Trending/{post_id}','TrendingController@SocialShareTrending');
Route::get('/trending/{post_id}','TrendingController@VisitSelectedUserPost');
Route::get('/visit-selected-user-post','TrendingController@GetPostStoryForSelectedUser');
Route::post('/get-people-trending-like-details','TrendingController@GetPeoplesTrendingLikeDetails');
/****************************************/
/************Message*************************/
Route::get('/visit-message-page','MessageController@MessageIndex');
Route::get('/visit-message-page/{id}','MessageController@VisitMessagePage');
Route::get('/message-read','MessageController@MessageRead');
Route::get('/load-header','MessageController@LoadRegisterHeader');
Route::post('/visit-selected-user','MessageController@Message');
Route::post('/chat-page','MessageController@ChatBetweenUser');
Route::get('/left-side-message-list','MessageController@LeftSideMessageList');
Route::get('/get-chat-details-first-appear','MessageController@GetDataForFirstAppearence');
Route::get('/get-chat-first-username','MessageController@GetChatFirstUserName');
Route::post('/load-chat-details','MessageController@LoadChatDetails');
Route::post('/search-people-from-list','MessageController@SearchPeopleFromList');
Route::post('/load-user-details','MessageController@LoadUserDetails');
Route::post('/message-search-username','MessageController@SearchFriend');
Route::post('/get-chat-with-friend','MessageController@GetChatWithFriend');
Route::post('/get-friend-details','MessageController@GetFriendDetails');
Route::get('/get-unread-message-notification','MessageController@UnreadMessageNotification');
Route::get('/get-detail-message-notification','MessageController@GetDetailMessageNotification');
Route::post('/get-other-conversations','MessageController@GetOtherConversations');
Route::get('/get-read-message-notification','MessageController@GetReadMessageNotification');
Route::post('/delete-entire-conversations','MessageController@DeleteEntireConversations');
Route::post('/delete-individual-chat','MessageController@DeleteIndividualChat');
/********************************************/
/******************My bet**********************/
Route::post('/my-bet-block','NewsFeedController@DisplayMyBet');
Route::post('/get-filtered-mybet-result','NewsFeedController@GetFilteredMyBetData');
Route::post('/my-bet-block-responsive','NewsFeedController@MyBetResponsive');
/***********************************************/
/************Encrypted Id***********************/
//Route::get('/get-encrypted-id','LandingPageController@GetEncryptedKey');
/***********************************************/
/******************Langauge**********************/
Route::post('/get-langauge','LandingPageController@SetLangauge');
/*************************************************/
/**********Soccer Controller**********************/
Route::get('/get-details','SoccerController@GetDetails');
Route::get('/get-country','SoccerController@GetCountryData');
Route::get('/get-competition','SoccerController@GetCompetitionData');
//Route::get('/get-standing','SoccerController@GetStandingsData');
Route::get('/get-odd-data','SoccerController@GetOddData');
Route::get('/get-event','SoccerController@GetEventData');
Route::get('/get-view','SoccerController@RenderViewPage');
Route::get('/display-country','SoccerController@DisplayCountry');
Route::get('/display-league','SoccerController@DisplayLeague');
Route::get('/display-events','SoccerController@DisplayEvents');
/*** betting section*****/
Route::get('/get-user-account-info','SoccerOddsController@GetUserAccountInfo');
Route::post('/get-data-according-to-bookmaker','SoccerOddsController@GetDataAccordingToBookmaker');
Route::get('/get-extra-odds','ExtraOddsController@GetExtraOdds');
Route::get('/move-to-extra-odd-page/{matchid}/{bookmaker}','ExtraOddsController@MoveToExtraOddPage');
Route::post('/get-data-according-to-bookmaker-for-extra-odd','ExtraOddsController@GetDataAccordingToBookmakerForExtraOdd');
Route::get('/check-session-for-extra-odds','ExtraOddsController@CheckSessionForExtraOdds');
Route::get('/check-session-for-accu-bet','ExtraOddsController@CheckSessionForAccuBet');
Route::get('/get-details-single-bet','ExtraOddsController@GetDetailsAboutSingleBet');
/*************************************************/
/***************social share**********************/
Route::get('/social-share-facebook/{postId}','NewsFeedController@SocialShareFacebook');
Route::get('/social-share-twitter/{postId}','NewsFeedController@SocialShareTwitter');
/*************************************************/
/*****************Save top league admin end*****************/
Route::post('/save-top-league','AdminSaveTopLeagueController@SaveTopLeague');
Route::post('/display-top-league','AdminSaveTopLeagueController@DisplayTopLeague');
Route::post('/save-featured-match','AdminSaveTopLeagueController@SaveFeaturedMatch');
/*************************************************/
/***************Head to Head**********************/
Route::post('/get-head-to-head-data','HeadToHeadController@GetHeadToHeadData');
/**************************************************/
/***** Invite Friend ****************************/
Route::get('/invite-friend','InviteFriend@loadPage');
Route::post('/send-mail','InviteFriend@sendMail');
Route::get('/check-authentication-of-friend/{randNos}','InviteFriend@checkAuthForFriend');
Route::get('/point-for-social-share','InviteFriend@pointForSocialShare');
/*********Integration of Betfair Login*****************/
Route::post('/betfair-login','BetFairController\loginController@BetfairLogin');
Route::post('/betfair-login-normal','BetFairController\loginController@BetfairLoginNormal');
Route::get('/sports','BetFairController\SportsTypesController@getSportsTypes');
/*********Integration of Betfair api*******************/
Route::get('/competitions','BetFairController\SportsTypesController@getAllCompetitions');
//Route::get('/competitions','BetFairController\SportsTypesController@getCountries');
Route::get('/get-next-item','BetFairController\SportsTypesController@getNextCountryName');
Route::post('/CheckOdds','BetFairController\BetPlacingController@CheckOddsDetails');
Route::get('/single-bet-info','BetFairController\BetPlacingController@SingleBetInfo');
Route::get('/accumulator-bet-info','BetFairController\BetPlacingController@AccumulatorBetInfo');
Route::post('/stake-value','BetFairController\BetPlacingController@InputStakeValue');
Route::post('/place-bet','BetFairController\BetPlacingController@BetPlaceData');
Route::post('/remove-odds-from-session','BetFairController\BetPlacingController@RemoveOddsFromSession');


Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('login/google', 'Auth\LoginController@redirectToProviderGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallbackGoogle');

?>
