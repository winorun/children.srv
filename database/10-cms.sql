DROP TABLE `files`, `galery`, `menu`;


ALTER TABLE `articles` CHANGE `publicationDate` `publication_date` DATE NOT NULL;

ALTER TABLE `articles` DROP `link`;

ALTER TABLE `articles` ADD `image_href` VARCHAR(255) NULL AFTER `content`;