-- ----------------------------
-- Records of email_templates
-- ----------------------------
INSERT INTO `email_templates` (`id`, `template_name`) VALUES
(2, 'account_activation.tpl');

-- ----------------------------
-- Table structure for pending_accounts
-- ----------------------------
DROP TABLE IF EXISTS `pending_accounts`;
CREATE TABLE `pending_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `expansion` int(3) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;