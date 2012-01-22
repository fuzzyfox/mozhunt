ALTER TABLE `user` ADD `registeredAt` INT( 4 ) UNSIGNED NOT NULL;

ALTER TABLE `user` ADD `activationKey` VARCHAR( 25 ) NULL;
