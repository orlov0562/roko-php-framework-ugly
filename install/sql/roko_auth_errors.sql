CREATE TABLE `roko_auth_errors` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ip` varchar(32) NOT NULL,
    `errors` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;