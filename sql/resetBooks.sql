DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS genres;
-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `genre_id` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `description`, `genre_id`) VALUES
(1, 'The Algorithm Design Manual', 'This newly expanded and updated second edition of the best-selling classic continues to take the "mystery" out of designing algorithms, and analyzing their efficacy and efficiency. Expanding on the first edition, the book now serves as the primary textbook of choice for algorithm design courses while maintaining its status as the premier practical reference guide to algorithms for programmers, researchers, and students.', 1),
(2, 'Cracking the Coding Interview: 189 Programming Questions and Solutions', 'I am not a recruiter. I am a software engineer. And as such, I know what it\'s like to be asked to whip up brilliant algorithms on the spot and then write flawless code on a whiteboard. I\'ve been through this as a candidate and as an interviewer. ', 1),
(3, 'Programming Challenges: The Programming Contest Training Manual', 'There are many distinct pleasures associated with computer programming. Craftsm- ship has its quiet rewards, the satisfaction that comes from building a useful object and making it work. Excitement arrives with the ?ash of insight that cracks a previously intractable problem. The spiritual quest for elegance can turn the hacker into an artist. Therearepleasuresinparsimony,insqueezingthelastdropofperformanceoutofclever algorithms ', 1),
(4, 'Data Structures and Algorithms in Java', 'The design and analysis of efficient data structures has long been recognized as a key component of the Computer Science curriculum. Goodrich, Tomassia and Goldwasser\'s approach to this classic topic is based on the object-oriented paradigm as the framework of choice for the design of data structures. For each ADT presented in the text, the authors provide an associated Java interface. Concrete data structures realizing the ADTs are provided as Java classes implementing the interfaces. The Java code implementing fundamental data structures in this book is ', 1);

-- --------------------------------------------------------


-- --------------------------------------------------------
--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(9) NOT NULL,
  `genre_name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`) VALUES
(1, 'Educational'),
(2, 'Mystery'),
(3, 'Romance');



--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

-- --------------------------------------------------------


--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;




ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;