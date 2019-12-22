DROP DATABASE IF EXISTS managerOneDatabase;

CREATE DATABASE managerOneDatabase;

USE managerOneDatabase;

--
-- Table structure for table `users`
--

CREATE TABLE  `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL
);

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `creation_date` date NOT NULL,
  `status` ENUM ('TODO', 'DONE') NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT fk_user_id
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

--
-- Dumping data for table `users`
--

INSERT INTO users (id, name, email) VALUES (null, 'Louis',  'louis.fontaine@efrei.net');
INSERT INTO `users` (`id`, `name`, `email`) VALUES (NULL, 'Marie', 'marielesang@gmail.com'), (NULL, 'Jérémie', 'jerembrebbo94@hotmail.fr');

--
-- Dumping data for table `tasks`
--

INSERT INTO tasks VALUES (null, 1, 'Talk to mama', 'talk to mama about how to wash my clothes', '2019-04-02 16:32:22', 'TODO');
INSERT INTO tasks VALUES (null, 2, 'Talk to mama', 'talk to mama about how to wash my clothes', '2019-04-02 16:32:22', 'TODO');
INSERT INTO tasks VALUES (null, 3, 'Talk to mama', 'talk to mama about how to wash my clothes', '2019-04-02 16:32:22', 'TODO');
INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `creation_date`, `status`) VALUES (NULL, '1', 'Work', 'Study for the english test', '2019-12-11', 'TODO');
INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `creation_date`, `status`) VALUES (NULL, '2', 'Work', 'Study for the english test', '2019-12-11', 'TODO');
INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `creation_date`, `status`) VALUES (NULL, '3', 'Work', 'Study for the english test', '2019-12-11', 'TODO');
INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `creation_date`, `status`) VALUES (NULL, '1', 'Clean', 'Clean the kitchen', '2019-12-14', 'DONE');
INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `creation_date`, `status`) VALUES (NULL, '2', 'Clean', 'Clean the kitchen', '2019-12-14', 'DONE');
INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `creation_date`, `status`) VALUES (NULL, '3', 'Clean', 'Clean the kitchen', '2019-12-14', 'DONE');
