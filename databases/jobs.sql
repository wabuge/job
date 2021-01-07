
--
-- Database: `jobs`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_applicants`
--

CREATE TABLE `tbl_applicants` (
  `id` int(11) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `userName` varchar(100) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `userPhone` int(12) DEFAULT NULL,
  `about` varchar(300) DEFAULT NULL,
  `postId` int(11) NOT NULL,
  `postTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) DEFAULT NULL,
  `targetPath` varchar(100) DEFAULT NULL,
  `textMssg` varchar(200) DEFAULT 'N',
  `clientSeen` varchar(100) NOT NULL DEFAULT 'N',
  `adminSeen` varchar(100) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posts`
--

CREATE TABLE `tbl_posts` (
  `id` int(11) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `companyEmail` varchar(100) NOT NULL,
  `companyPhone` int(12) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `detail` varchar(1000) DEFAULT NULL,
  `postTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `startDate` varchar(100) DEFAULT NULL,
  `deadlineDate` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPass` varchar(100) NOT NULL,
  `userPhone` int(12) DEFAULT NULL,
  `about` varchar(1000) DEFAULT NULL,
  `cv` varchar(200) DEFAULT 'N',
  `location` varchar(100) DEFAULT NULL,
  `loginType` varchar(100) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userEmail`, `userPass`, `userPhone`, `about`, `cv`, `location`, `loginType`) VALUES
(1, 'Admin', 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 712121212, '', '', NULL, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_applicants`
--
ALTER TABLE `tbl_applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `companyName` (`companyName`),
  ADD KEY `userName` (`userName`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `companyName` (`companyName`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`),
  ADD KEY `userName` (`userName`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_applicants`
--
ALTER TABLE `tbl_applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_applicants`
--
ALTER TABLE `tbl_applicants`
  ADD CONSTRAINT `foreignkeypostid` FOREIGN KEY (`postId`) REFERENCES `tbl_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
