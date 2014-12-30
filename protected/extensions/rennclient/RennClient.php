<?php
include_once ('RennClientBase.php');
include_once ('service/AlbumService.php');
include_once ('service/BlogService.php');
include_once ('service/ShareService.php');
include_once ('service/UbbService.php');
include_once ('service/NotificationService.php');
include_once ('service/FeedService.php');
include_once ('service/InvitationService.php');
include_once ('service/ProfileService.php');
include_once ('service/AppService.php');
include_once ('service/StatusService.php');
include_once ('service/LikeService.php');
include_once ('service/PhotoService.php');
include_once ('service/CommentService.php');
include_once ('service/UserService.php');
include_once ('service/FriendService.php');

class RennClient extends RennClientBase {
        private $albumService;
        private $blogService;
        private $shareService;
        private $ubbService;
        private $notificationService;
        private $feedService;
        private $invitationService;
        private $profileService;
        private $appService;
        private $statusService;
        private $likeService;
        private $photoService;
        private $commentService;
        private $userService;
        private $friendService;
        function getAlbumService() {
                if (empty ($this -> albumService )) {
                        $this->albumService = new AlbumService ( $this, $this->accessToken );
                }
                return $this->albumService;
        }
        function getBlogService() {
                if (empty ($this -> blogService )) {
                        $this->blogService = new BlogService ( $this, $this->accessToken );
                }
                return $this->blogService;
        }
        function getShareService() {
                if (empty ($this -> shareService )) {
                        $this->shareService = new ShareService ( $this, $this->accessToken );
                }
                return $this->shareService;
        }
        function getUbbService() {
                if (empty ($this -> ubbService )) {
                        $this->ubbService = new UbbService ( $this, $this->accessToken );
                }
                return $this->ubbService;
        }
        function getNotificationService() {
                if (empty ($this -> notificationService )) {
                        $this->notificationService = new NotificationService ( $this, $this->accessToken );
                }
                return $this->notificationService;
        }
        function getFeedService() {
                if (empty ($this -> feedService )) {
                        $this->feedService = new FeedService ( $this, $this->accessToken );
                }
                return $this->feedService;
        }
        function getInvitationService() {
                if (empty ($this -> invitationService )) {
                        $this->invitationService = new InvitationService ( $this, $this->accessToken );
                }
                return $this->invitationService;
        }
        function getProfileService() {
                if (empty ($this -> profileService )) {
                        $this->profileService = new ProfileService ( $this, $this->accessToken );
                }
                return $this->profileService;
        }
        function getAppService() {
                if (empty ($this -> appService )) {
                        $this->appService = new AppService ( $this, $this->accessToken );
                }
                return $this->appService;
        }
        function getStatusService() {
                if (empty ($this -> statusService )) {
                        $this->statusService = new StatusService ( $this, $this->accessToken );
                }
                return $this->statusService;
        }
        function getLikeService() {
                if (empty ($this -> likeService )) {
                        $this->likeService = new LikeService ( $this, $this->accessToken );
                }
                return $this->likeService;
        }
        function getPhotoService() {
                if (empty ($this -> photoService )) {
                        $this->photoService = new PhotoService ( $this, $this->accessToken );
                }
                return $this->photoService;
        }
        function getCommentService() {
                if (empty ($this -> commentService )) {
                        $this->commentService = new CommentService ( $this, $this->accessToken );
                }
                return $this->commentService;
        }
        function getUserService() {
                if (empty ($this -> userService )) {
                        $this->userService = new UserService ( $this, $this->accessToken );
                }
                return $this->userService;
        }
        function getFriendService() {
                if (empty ($this -> friendService )) {
                        $this->friendService = new FriendService ( $this, $this->accessToken );
                }
                return $this->friendService;
        }
}
?>
