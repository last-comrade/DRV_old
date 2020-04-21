CREATE TABLE `UserDetail` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `_i_UserDetail_user_email` (`user_email` ASC)
);

CREATE TABLE `MessageDetail` (
  `message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_code` varchar(20) DEFAULT NULL,
  `message_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message_title` varchar(255) DEFAULT NULL,
  `message_content` text,
  `message_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  INDEX `_i_MessageDetail_message_code` (`message_code` ASC),
  INDEX `_i_MessageDetail_message_time` (`message_code` DESC)
);

CREATE TABLE `VerificationDetail` (
  `verification_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_id` bigint(20) NOT NULL,
  `is_verified` tinyint(1) DEFAULT NULL,
  `verified_by` bigint(20) NOT NULL,
  PRIMARY KEY (`verification_id`),
  INDEX `_i_VerificationDetail_is_verified` (`is_verified` ASC),
  CONSTRAINT FK_MessageDetail FOREIGN KEY (message_id)
    REFERENCES MessageDetail(message_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_UserDetail FOREIGN KEY (verified_by)
    REFERENCES UserDetail(user_id) ON DELETE RESTRICT ON UPDATE RESTRICT
);
