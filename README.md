# todo_list
Manages ToDo Items 

Database Creation

Create the Database (default is test_task). You can use this SQL with some sample data:

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo_item`
--

CREATE TABLE IF NOT EXISTS `todo_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `todo_item`
--

INSERT INTO `todo_item` (`id`, `name`, `status`) VALUES
(1, 'go to the market', 0),
(2, 'Save', 0),
(3, 'Finish Task', 0),
(4, 'Run away', 0),
(5, 'Go to sleep', 1),
(6, 'Stop it', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


Database Configuration

Go to Model/DbManager.php line 41 and edit the database settings

Running the App

When all is set, just request index.php

Have fun!

