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

INSERT INTO users (id, name, email) VALUES (null, 'louisfontaine',  'louis.fontaine@efrei.net');

--
-- Dumping data for table `tasks`
--

INSERT INTO tasks VALUES (null, 1, 'Talk to mama', 'talk to mama about how to wash my clothes', '2019-04-02 16:32:22', 'TODO');
