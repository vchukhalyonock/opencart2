--
-- Table structure for table `videosGroups`
--

DROP TABLE IF EXISTS `oc_videos_groups`;
CREATE TABLE `oc_videos_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `videosGroups`
--
ALTER TABLE `oc_videos_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `videosGroups`
--
ALTER TABLE `oc_videos_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--



--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `oc_videos`;
CREATE TABLE `oc_videos` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `videoStatus` enum('new','download','downloaded','upload','ready','err_download','err_upload','not_ready') DEFAULT 'new',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `customerLink` varchar(255) NOT NULL,
  `channelLink` varchar(255) DEFAULT NULL,
  `thumbnailID` int(11) DEFAULT NULL,
  `customerId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `videos`
--
ALTER TABLE `oc_videos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customerLink_UNIQUE` (`customerLink`),
  ADD UNIQUE KEY `channelLink_UNIQUE` (`channelLink`),
  ADD KEY `fk_videos_siteUserId_idx` (`customerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `oc_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--





--
-- Table structure for table `videosGroupsAssoc`
--

DROP TABLE IF EXISTS `oc_videos_groups_assoc`;
CREATE TABLE `oc_videos_groups_assoc` (
  `videoId` int(11) NOT NULL,
  `groupId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `videosGroupsAssoc`
--
ALTER TABLE `oc_videos_groups_assoc`
  ADD UNIQUE KEY `groupId_UNIQUE` (`groupId`,`videoId`);

