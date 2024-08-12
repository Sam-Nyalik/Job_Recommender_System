-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 12, 2024 at 11:50 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_recommender_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `userName` varchar(200) NOT NULL,
  `emailAddress` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `userName`, `emailAddress`, `password`, `date_created`, `updation_date`) VALUES
(4, 'Sam Nyalik Jr', 'snyalik@gmail.com', '$2y$10$/Cmfi7uTooWDggMlFz4HsOFS8ysUWcda0rHz37NnHK.CZlnV5cih2', '2024-08-06 22:02:19', '2024-08-12 00:39:59'),
(5, 'wendy carren', 'wendy@gmail.com', '$2y$10$i7dHNt5zQLDBekNTCjKlT.Jbd15J9mshwU3JU31.n9HbVe6AXZtxq', '2024-08-06 22:09:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE `counties` (
  `id` int(11) NOT NULL,
  `county_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `users` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counties`
--

INSERT INTO `counties` (`id`, `county_name`, `date_created`, `updation_date`, `users`) VALUES
(1, 'Nairobi County', '2024-05-25 02:10:14', '2024-07-30 15:04:14', NULL),
(2, 'Mombasa County', '2024-05-27 11:16:33', '2024-07-30 15:04:06', NULL),
(3, 'Nakuru County', '2024-06-03 18:44:32', '2024-07-30 15:03:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employmentType`
--

CREATE TABLE `employmentType` (
  `id` int(11) NOT NULL,
  `employmentType_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employmentType`
--

INSERT INTO `employmentType` (`id`, `employmentType_name`, `date_created`, `updation_date`) VALUES
(1, 'Freelance', '2024-05-28 08:25:39', NULL),
(2, 'Full Time', '2024-05-28 08:26:45', NULL),
(3, 'Part Time', '2024-05-28 08:26:54', NULL),
(4, 'Self-Employed', '2024-05-28 08:27:02', NULL),
(5, 'Contract', '2024-05-28 08:27:09', NULL),
(6, 'Internship', '2024-05-28 08:27:16', NULL),
(7, 'Apprenticeship', '2024-05-28 08:27:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `jobApplicationId` int(11) NOT NULL,
  `candidateName` varchar(255) NOT NULL,
  `candidateEmailAddress` varchar(255) NOT NULL,
  `candidateId` int(11) NOT NULL,
  `companyName` varchar(200) NOT NULL,
  `posted_jobTitle` varchar(255) NOT NULL,
  `posted_jobLocation` varchar(255) NOT NULL,
  `posted_jobDescription` varchar(1500) NOT NULL,
  `posted_jobEmploymentType` varchar(200) NOT NULL,
  `posted_jobId` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `application_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`jobApplicationId`, `candidateName`, `candidateEmailAddress`, `candidateId`, `companyName`, `posted_jobTitle`, `posted_jobLocation`, `posted_jobDescription`, `posted_jobEmploymentType`, `posted_jobId`, `date_created`, `updation_date`, `application_status`) VALUES
(1, 'Theo Omondi', 'theo@gmail.com', 6, 'Ensoniq Trading Company', 'Software Engineer', 'Nairobi', '1. Design visually appealing and user-friendly B2B e-commerce websites that meet the needs of business customers\r\n2. Develop wireframes, mockups, and prototypes to communicate design ideas and concepts.\r\n3. Ensure websites are responsive and optimized for performance across various devices and screen sizes.\r\n4. Collaborate with the marketing team to develop and execute digital marketing campaigns across multiple channels, including social media, email, and search engines.\r\n5. Monitor website traffic and performance metrics, and implement strategies to improve SEO and conversion rates.\r\n6. Create and curate engaging content for website, social media, and other digital platforms.\r\n7. Stay up-to-date with industry trends and best practices in web design, user experience, and digital marketing.', 'Internship', 2, '2024-07-14 16:29:50', '2024-08-12 03:42:25', 1),
(2, 'Collo Kiptoo', 'collo@gmail.com', 9, 'Afripixel Solutions', 'Business Developer', 'Nairobi', '1. Client Acquisition: Identify and pursue new business opportunities through various channels such as networking, cold calling, and online research.\r\n2.  Market Research: Conduct thorough market research to identify potential clients and understand their digital marketing needs.\r\n3. Lead Generation: Develop and implement strategies to generate leads and convert them into clients.\r\n4. Relationship Management: Build and maintain strong relationships with clients, ensuring their needs are understood and met with tailored digital marketing solutions.\r\n5. Sales Presentations: Prepare and deliver compelling presentations and proposals to prospective clients, in collaboration with the Digital Marketing Director.\r\n6. Collaboration: Work closely with the Digital Marketing Director and internal teams to develop effective marketing strategies and campaigns for clients.\r\n7. Negotiation: Assist in negotiating contracts and agreements, ensuring alignment with company goals and client expectations.\r\n8. Performance Tracking: Monitor and report on sales performance, providing insights to the Digital Marketing Director to ensure targets are met or exceeded.\r\n9.  Feedback Loop: Provide feedback to the Digital Marketing Director and internal teams on market trends, client needs, and competitive landscape.', 'Full Time', 6, '2024-07-15 07:49:41', NULL, 0),
(3, 'Theo Omondi', 'theo@gmail.com', 6, 'Nandasaba Tech. Company', 'Computer Programmer', 'Nairobi', '1. Development and testing of computer systems', 'Full Time', 8, '2024-07-15 15:48:26', NULL, 0),
(4, 'Theo Omondi', 'theo@gmail.com', 6, 'Ensoniq Trading Company', 'Software Engineer', 'Nairobi', '1. Design visually appealing and user-friendly B2B e-commerce websites that meet the needs of business customers\r\n2. Develop wireframes, mockups, and prototypes to communicate design ideas and concepts.\r\n3. Ensure websites are responsive and optimized for performance across various devices and screen sizes.\r\n4. Collaborate with the marketing team to develop and execute digital marketing campaigns across multiple channels, including social media, email, and search engines.\r\n5. Monitor website traffic and performance metrics, and implement strategies to improve SEO and conversion rates.\r\n6. Create and curate engaging content for website, social media, and other digital platforms.\r\n7. Stay up-to-date with industry trends and best practices in web design, user experience, and digital marketing.', 'Internship', 2, '2024-07-26 10:19:11', NULL, 0),
(5, 'Theo Omondi', 'theo@gmail.com', 6, 'Lynn & Associates', 'Driver', 'Nairobi', 'Driver must be always available', 'Full Time', 7, '2024-07-29 08:30:42', '2024-08-12 12:20:43', 2),
(6, 'Lynn Kyalo', 'lynn@gmail.com', 10, 'Afripixel Solutions', 'Business Developer', 'Nairobi', '1. Client Acquisition: Identify and pursue new business opportunities through various channels such as networking, cold calling, and online research.\r\n2.  Market Research: Conduct thorough market research to identify potential clients and understand their digital marketing needs.\r\n3. Lead Generation: Develop and implement strategies to generate leads and convert them into clients.\r\n4. Relationship Management: Build and maintain strong relationships with clients, ensuring their needs are understood and met with tailored digital marketing solutions.\r\n5. Sales Presentations: Prepare and deliver compelling presentations and proposals to prospective clients, in collaboration with the Digital Marketing Director.\r\n6. Collaboration: Work closely with the Digital Marketing Director and internal teams to develop effective marketing strategies and campaigns for clients.\r\n7. Negotiation: Assist in negotiating contracts and agreements, ensuring alignment with company goals and client expectations.\r\n8. Performance Tracking: Monitor and report on sales performance, providing insights to the Digital Marketing Director to ensure targets are met or exceeded.\r\n9.  Feedback Loop: Provide feedback to the Digital Marketing Director and internal teams on market trends, client needs, and competitive landscape.', 'Full Time', 6, '2024-07-29 08:55:37', '2024-08-12 03:42:13', 1),
(7, 'Collo Kiptoo', 'collo@gmail.com', 9, 'Lynn & Associates', 'Driver', 'Nairobi', 'Driver must be always available', 'Full Time', 7, '2024-08-12 02:08:58', '2024-08-12 03:42:05', 2),
(8, 'Fiona Omolo', 'fiona@gmail.com', 11, 'Afripixel Solutions', 'Business Developer', 'Nairobi', '1. Client Acquisition: Identify and pursue new business opportunities through various channels such as networking, cold calling, and online research.\r\n2.  Market Research: Conduct thorough market research to identify potential clients and understand their digital marketing needs.\r\n3. Lead Generation: Develop and implement strategies to generate leads and convert them into clients.\r\n4. Relationship Management: Build and maintain strong relationships with clients, ensuring their needs are understood and met with tailored digital marketing solutions.\r\n5. Sales Presentations: Prepare and deliver compelling presentations and proposals to prospective clients, in collaboration with the Digital Marketing Director.\r\n6. Collaboration: Work closely with the Digital Marketing Director and internal teams to develop effective marketing strategies and campaigns for clients.\r\n7. Negotiation: Assist in negotiating contracts and agreements, ensuring alignment with company goals and client expectations.\r\n8. Performance Tracking: Monitor and report on sales performance, providing insights to the Digital Marketing Director to ensure targets are met or exceeded.\r\n9.  Feedback Loop: Provide feedback to the Digital Marketing Director and internal teams on market trends, client needs, and competitive landscape.', 'Full Time', 6, '2024-08-12 02:33:26', '2024-08-12 03:02:05', 1),
(9, 'Thomas Atin', 'atin@gmail.com', 12, 'Afripixel Solutions', 'Business Developer', 'Nairobi', '1. Client Acquisition: Identify and pursue new business opportunities through various channels such as networking, cold calling, and online research.\r\n2.  Market Research: Conduct thorough market research to identify potential clients and understand their digital marketing needs.\r\n3. Lead Generation: Develop and implement strategies to generate leads and convert them into clients.\r\n4. Relationship Management: Build and maintain strong relationships with clients, ensuring their needs are understood and met with tailored digital marketing solutions.\r\n5. Sales Presentations: Prepare and deliver compelling presentations and proposals to prospective clients, in collaboration with the Digital Marketing Director.\r\n6. Collaboration: Work closely with the Digital Marketing Director and internal teams to develop effective marketing strategies and campaigns for clients.\r\n7. Negotiation: Assist in negotiating contracts and agreements, ensuring alignment with company goals and client expectations.\r\n8. Performance Tracking: Monitor and report on sales performance, providing insights to the Digital Marketing Director to ensure targets are met or exceeded.\r\n9.  Feedback Loop: Provide feedback to the Digital Marketing Director and internal teams on market trends, client needs, and competitive landscape.', 'Full Time', 6, '2024-08-12 03:32:49', '2024-08-12 03:33:37', 1),
(10, 'Canon Were', 'canon@gmail.com', 13, 'Ensoniq Trading Company', 'Software Engineer', 'Nairobi', '1. Design visually appealing and user-friendly B2B e-commerce websites that meet the needs of business customers\r\n2. Develop wireframes, mockups, and prototypes to communicate design ideas and concepts.\r\n3. Ensure websites are responsive and optimized for performance across various devices and screen sizes.\r\n4. Collaborate with the marketing team to develop and execute digital marketing campaigns across multiple channels, including social media, email, and search engines.\r\n5. Monitor website traffic and performance metrics, and implement strategies to improve SEO and conversion rates.\r\n6. Create and curate engaging content for website, social media, and other digital platforms.\r\n7. Stay up-to-date with industry trends and best practices in web design, user experience, and digital marketing.', 'Internship', 2, '2024-08-12 12:47:33', '2024-08-12 12:48:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_industries`
--

CREATE TABLE `job_industries` (
  `id` int(11) NOT NULL,
  `industryName` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `updationDate` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_industries`
--

INSERT INTO `job_industries` (`id`, `industryName`, `dateCreated`, `updationDate`) VALUES
(5, 'Finance', '2024-08-06 22:17:42', NULL),
(6, 'Information Technology', '2024-08-06 22:17:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_levels`
--

CREATE TABLE `job_levels` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updationDate` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_levels`
--

INSERT INTO `job_levels` (`id`, `name`, `creationDate`, `updationDate`) VALUES
(1, 'Senior Level', '2024-07-02 22:04:14', NULL),
(2, 'Mid Level', '2024-07-02 22:04:37', NULL),
(3, 'Internship & Graduate', '2024-07-02 22:04:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_titles`
--

CREATE TABLE `job_titles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_titles`
--

INSERT INTO `job_titles` (`id`, `name`, `date_created`, `updation_date`) VALUES
(1, 'Software Engineer', '2024-06-04 14:44:32', NULL),
(2, 'Data Scientist', '2024-06-04 14:44:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posted_jobs`
--

CREATE TABLE `posted_jobs` (
  `jobId` int(11) NOT NULL,
  `jobTitle` varchar(200) NOT NULL,
  `jobDescription` varchar(6000) NOT NULL,
  `jobEmploymentType` varchar(200) NOT NULL,
  `companyName` varchar(200) NOT NULL,
  `totalApplicants` int(11) DEFAULT NULL,
  `coreQualifications` varchar(1200) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL,
  `jobLocation` varchar(255) NOT NULL,
  `job_level` varchar(200) NOT NULL,
  `job_salary` varchar(200) NOT NULL,
  `application_deadline` date NOT NULL,
  `job_industry` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posted_jobs`
--

INSERT INTO `posted_jobs` (`jobId`, `jobTitle`, `jobDescription`, `jobEmploymentType`, `companyName`, `totalApplicants`, `coreQualifications`, `date_created`, `updation_date`, `status`, `jobLocation`, `job_level`, `job_salary`, `application_deadline`, `job_industry`) VALUES
(2, 'Software Engineer', '1. Design visually appealing and user-friendly B2B e-commerce websites that meet the needs of business customers\r\n2. Develop wireframes, mockups, and prototypes to communicate design ideas and concepts.\r\n3. Ensure websites are responsive and optimized for performance across various devices and screen sizes.\r\n4. Collaborate with the marketing team to develop and execute digital marketing campaigns across multiple channels, including social media, email, and search engines.\r\n5. Monitor website traffic and performance metrics, and implement strategies to improve SEO and conversion rates.\r\n6. Create and curate engaging content for website, social media, and other digital platforms.\r\n7. Stay up-to-date with industry trends and best practices in web design, user experience, and digital marketing.', 'Internship', 'Ensoniq Trading Company', NULL, '1. Bachelor\'s Degree in Web Design, Digital Marketing, Software Engineering or related field, Relevant Industry Certifications\r\n2. Strong understanding of responsive design principles and best practices.\r\n3. Integrate payment gateways, inventory management systems, and other necessary e-commerce functionalities\r\n4. Knowledge of HTML, CSS, and JavaScript is a Mandatory\r\n5. Experience with digital marketing tools and platforms, including Google Analytics, SEO tools, and social media management platforms.\r\n6. Excellent communication and collaboration skills.\r\n7. Creative thinking and problem-solving abilities.\r\n8. Ability to work independently and as part of a team.\r\n9. Portfolio showcasing previous web design projects and digital marketing campaigns.\r\n10. Knowledge of user experience (UX) and user interface (UI) design principles.\r\n11. Familiarity with analytics tools such as Google Analytics.', '2024-06-27', '2024-07-06 15:45:08', 1, 'Nairobi', ' Senior Level', '', '0000-00-00', ''),
(4, 'System Analyst', 'We want a qualified system analyst to work for us', 'Full Time', 'CUEA', NULL, 'Bsc. Systems Engineering', '2024-07-08', NULL, 1, 'Nairobi', 'Mid Level', '', '0000-00-00', ''),
(5, 'Internal Auditor', '1. Audit Planning and Execution. Plan and execute internal audit engagements in accordance with professional auditing standards and company policies.\r\n2. Risk Management and Compliance. Evaluate the effectiveness of internal controls by performing risk assessments, control testing, and substantive procedures.\r\n3. Identify areas of potential risk and recommend controls to mitigate risks and improve operational efficiency. Stay informed about changes in regulatory requirements, industry best practices, and emerging risks to proactively identify areas for improvement.\r\n4. Documentation and Reporting. Prepare detailed audit work papers, findings, and reports documenting audit procedures, observations, and recommendations.\r\n5. Communicate audit findings and recommendations to management clearly and concisely.', 'Freelance', 'Unga Limited', NULL, '1. Bachelor’s degree in accounting, Finance, or a related field. CPA, CIA, or other relevant certification.\r\n2. 2 years of experience in internal auditing, external auditing, or risk management.\r\n3. Strong understanding of internal control concepts, risk assessment methodologies, and auditing standards (e.g. COSO, IIA standards).\r\n4. Excellent analytical skills with the ability to evaluate complex processes and identify areas of risk or inefficiency.\r\n5. Proficiency in Microsoft Office Suite and experience with audit software or data analytics tools.\r\n6. Effective communication skills, including the ability to clearly articulate audit findings and recommendations to various stakeholders.\r\n7. Detail-oriented with strong organizational skills and the ability to manage multiple priorities and deadlines.\r\n8. Commitment to integrity, professionalism, and continuous learning', '2024-07-11', NULL, 1, 'Nakuru', 'Mid Level', 'Ksh. 150,000', '2024-07-25', ''),
(6, 'Business Developer', '1. Client Acquisition: Identify and pursue new business opportunities through various channels such as networking, cold calling, and online research.\r\n2.  Market Research: Conduct thorough market research to identify potential clients and understand their digital marketing needs.\r\n3. Lead Generation: Develop and implement strategies to generate leads and convert them into clients.\r\n4. Relationship Management: Build and maintain strong relationships with clients, ensuring their needs are understood and met with tailored digital marketing solutions.\r\n5. Sales Presentations: Prepare and deliver compelling presentations and proposals to prospective clients, in collaboration with the Digital Marketing Director.\r\n6. Collaboration: Work closely with the Digital Marketing Director and internal teams to develop effective marketing strategies and campaigns for clients.\r\n7. Negotiation: Assist in negotiating contracts and agreements, ensuring alignment with company goals and client expectations.\r\n8. Performance Tracking: Monitor and report on sales performance, providing insights to the Digital Marketing Director to ensure targets are met or exceeded.\r\n9.  Feedback Loop: Provide feedback to the Digital Marketing Director and internal teams on market trends, client needs, and competitive landscape.', 'Full Time', 'Afripixel Solutions', NULL, '1.  Bachelor’s degree in Business Administration, Marketing, or a related field\r\n2. Proven experience as a Business Developer, Sales Executive, or relevant role in a digital marketing agency or related industry.\r\n3. Strong understanding of digital marketing services, including SEO, PPC, social media, content marketing, and web development.\r\n4. Excellent communication, negotiation, and presentation skills.\r\n5. Ability to build and maintain strong client relationships.\r\n6. Strong analytical and problem-solving skills.\r\n7. Self-motivated with a results-driven approach.\r\n8. Ability to work independently and as part of a team.\r\n9. Proficiency in CRM software and MS Office.', '2024-07-11', NULL, 1, 'Nairobi', 'Senior Level', 'Ksh. 100,000', '2024-07-26', ''),
(7, 'Driver', 'Driver must be always available', 'Full Time', 'Lynn & Associates', NULL, 'Driving Licence', '2024-07-12', '2024-08-12 03:24:24', 0, 'Nairobi', 'Senior Level', 'Ksh. 50,000', '2024-07-26', ''),
(8, 'Computer Programmer', '1. Development and testing of computer systems', 'Full Time', 'Nandasaba Tech. Company', NULL, '1. Bsc. Computer Science\r\n2. Python \r\n3. MySQL', '2024-07-15', NULL, 1, 'Nairobi', 'Mid Level', 'Ksh. 200,000', '2024-07-31', ''),
(9, 'Development Officer', 'The African Population and Health Research Center (APHRC) is a premier research-to-policy institution, generating evidence, strengthening research and related capacity in the African research and development ecosystem, and engaging policy to inform action on health and development. The Center is Africa-based and African-led, with its headquarters in Nairobi, Kenya, and a West Africa Regional Office (WARO), in Dakar, Senegal. APHRC seeks to drive change by developing strong African research leadership and promoting evidence-informed decision-making (EIDM) across sub-Saharan Africa.', 'Full Time', 'APHRC', NULL, '1.A Bachelor’s degree and postgraduate training in a relevant field from a recognized university.\r\n2.At least 6 years post-qualification work experience as a Development or Grant Officer.\r\n3.Proven experience in fundraising and grants management.\r\n4.Knowledge of, and experience in using various business development information systems.\r\n5.Excellent interpersonal skills and ability to effectively work with diverse teams.\r\n6.Excellent written and oral communication skills.', '2024-08-12', NULL, 1, 'Nairobi County', 'Mid Level', 'Ksh. 165,000', '2024-08-23', ''),
(10, 'Senior Accountant', '1.Coordinate and assist with internal and external audits.\r\n2.Ensure compliance with tax regulations and filing requirements.\r\n3.Implement and monitor internal controls to safeguard company assets.\r\n4.Analysis and Support', 'Full Time', 'Victoria Courts', NULL, '1.Bachelor’s degree in Accounting, Finance, or related field.\r\n2.CPA-K', '2024-08-12', NULL, 1, 'Nairobi County', 'Senior Level', 'Ksh. 550,000', '2024-08-16', 'Finance');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updation_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skill_name`, `date_created`, `updation_date`) VALUES
(1, 'Web development', '2024-05-28 13:49:56', NULL),
(2, 'Programming', '2024-05-28 13:50:13', NULL),
(3, 'Mobile Application development', '2024-05-28 13:50:54', NULL),
(4, 'Machine Learning', '2024-05-28 13:51:28', NULL),
(5, 'Data Science', '2024-05-28 13:51:37', NULL),
(6, 'Data Analytics', '2024-05-28 13:52:02', NULL),
(7, 'Marketing', '2024-05-28 13:52:37', NULL),
(10, 'Problem solving', '2024-08-07 09:10:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `emailAddress` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profilePhoto` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `skills` varchar(200) NOT NULL,
  `universityAttended` varchar(200) DEFAULT NULL,
  `universityStartYear` varchar(200) DEFAULT NULL,
  `universityEndYear` varchar(200) DEFAULT NULL,
  `recentJobTitle` varchar(200) DEFAULT NULL,
  `recentEmploymentType` varchar(200) DEFAULT NULL,
  `recentEmploymentCompany` varchar(200) DEFAULT NULL,
  `preferredJobTitle` varchar(200) NOT NULL,
  `preferredJobLocation` varchar(200) NOT NULL,
  `profileCreationDate` datetime NOT NULL DEFAULT current_timestamp(),
  `profileUpdationDate` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `course` varchar(255) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `non_student` int(11) DEFAULT NULL,
  `skill_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `preferredJobTitle_id` int(11) NOT NULL,
  `preferredJobLocation_id` int(11) NOT NULL,
  `resume` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `emailAddress`, `password`, `profilePhoto`, `location`, `skills`, `universityAttended`, `universityStartYear`, `universityEndYear`, `recentJobTitle`, `recentEmploymentType`, `recentEmploymentCompany`, `preferredJobTitle`, `preferredJobLocation`, `profileCreationDate`, `profileUpdationDate`, `course`, `student`, `non_student`, `skill_id`, `location_id`, `preferredJobTitle_id`, `preferredJobLocation_id`, `resume`) VALUES
(6, 'Theo Omondi', 'theo@gmail.com', '$2y$10$aXB8V1cgH6s/j8FM.dmjr.c.skQoaBl.WVh3gSUIaZw8g7LyqBD6e', 'users/profilePhotos/20545632_1718205608475432_1916377436953848468_o.jpg', 'Nairobi', 'Data Analytics', 'KCA', '2024-07-01', '2024-07-01', 'Software Engineer', 'Self-Employed', 'self employed', 'Software Engineer', 'Nairobi', '2024-07-01 15:59:56', '2024-08-12 09:06:22', 'BBIT', 1, 1, 6, 1, 1, 1, ''),
(7, 'Martin Chuiri', 'mrtin@gmail.com', '$2y$10$L4uy9fj8Q8cnkax5uPoWl.ZbJG71C0xP5oOowYIjuZTt/.Ew6GEES', 'users/profilePhotos/20545632_1718205608475432_1916377436953848468_o.jpg', 'Mombasa', 'Mobile Application development', '', '', '', 'Software Engineer', 'Part Time', 'Kenya Power', 'Data Scientist', 'Nairobi', '2024-07-01 16:03:43', NULL, '', NULL, 1, 3, 2, 2, 1, ''),
(8, 'Tony Brian', 'tony@gmail.com', '$2y$10$doCch5NXJuuqOvf6haATP.6hsFbaelTdvnXHFBpSfhRAysKLl3/lq', 'users/profilePhotos/38122922_1874769109485747_515700154909589504_n.jpg', 'Mombasa', 'Data Science', 'JKUAT Karen', '2024-07-01', '2024-07-01', '', '', '', 'Data Scientist', 'Mombasa', '2024-07-01 16:12:19', NULL, 'Data Science', 1, NULL, 5, 2, 2, 2, ''),
(9, 'Collo Kiptoo', 'collo@gmail.com', '$2y$10$ioQh8l4c1ITKDJex61o9.OZBkgyWJ9ynQ1STs8z854KylUkrwCnUu', 'users/profilePhotos/image1.jpg', 'Nakuru', 'Mobile Application development', 'JKUAT', '2019-09-03', '2025-11-03', '', '', '', 'Software Engineer', 'Nairobi', '2024-07-03 11:49:36', NULL, 'BSc. Computer Science', 1, NULL, 3, 3, 1, 1, ''),
(10, 'Lynn Kyalo', 'lynn@gmail.com', '$2y$10$UrLJ.GVlsVPrLSuT6UqUkedHv42kB5okmUlfqzCaA7U20ySm97y8i', 'users/profilePhotos/image1.jpg', 'Nairobi', 'Data Analytics', 'KCA', '2020-01-10', '2024-11-22', '', '', '', 'Software Engineer', 'Nakuru', '2024-07-12 16:04:23', NULL, 'BSc. IT', 1, NULL, 6, 1, 1, 3, ''),
(11, 'Fiona Omolo', 'fiona@gmail.com', '$2y$10$3B4YGheWxnYsVeyDY60xGep0xmVDfIXR/tidhEmBU.qvNFKRoKaKa', 'users/profilePhotos/image1.jpg', 'Nairobi', 'Programming', '', '', '', 'Advocate', 'Full Time', 'JRO', 'Data Scientist', 'Mombasa', '2024-07-14 22:15:03', NULL, '', NULL, 1, 2, 1, 2, 2, 'users/resumes/SAM-NYALIK CV.pdf'),
(12, 'Thomas Atin', 'atin@gmail.com', '$2y$10$AjD.RGAnt.DpzQ/0EFdxzuD67ULMlSz.xi0uZZDBfPUO9Z8Co80Fq', 'users/profilePhotos/20545632_1718205608475432_1916377436953848468_o.jpg', 'Mombasa County', 'Data Analytics', '', '', '', 'Lawyer', 'Full Time', 'High Court of Kenya', 'Data Scientist', 'Nairobi County', '2024-08-12 03:32:15', NULL, '', NULL, 1, 6, 2, 2, 1, 'users/resumes/SAM-NYALIK CV.pdf'),
(13, 'Canon Were', 'canon@gmail.com', '$2y$10$wSFWbfo4ai1JRtTAlY3.W.HnWfkKy2BMjp5EnTkSPcWw5I7Ly22mi', 'users/profilePhotos/image2.jpg', 'Mombasa County', 'Machine Learning', 'The Catholic University of Eastern Africa', '2024-08-12', '2024-08-29', '', '', '', 'Data Scientist', 'Nairobi County', '2024-08-12 12:43:36', NULL, 'BSc. Computer Science', 1, NULL, 4, 2, 2, 1, 'users/resumes/SAM-NYALIK CV.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `counties`
--
ALTER TABLE `counties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employmentType`
--
ALTER TABLE `employmentType`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`jobApplicationId`),
  ADD KEY `candidateId` (`candidateId`),
  ADD KEY `posted_jobId` (`posted_jobId`);

--
-- Indexes for table `job_industries`
--
ALTER TABLE `job_industries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_levels`
--
ALTER TABLE `job_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_titles`
--
ALTER TABLE `job_titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posted_jobs`
--
ALTER TABLE `posted_jobs`
  ADD PRIMARY KEY (`jobId`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `fk_skills` (`skill_id`),
  ADD KEY `fk_location` (`location_id`),
  ADD KEY `fk_preferredJobLocation_id` (`preferredJobLocation_id`),
  ADD KEY `fk_preferredJobTitle_id` (`preferredJobTitle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `counties`
--
ALTER TABLE `counties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employmentType`
--
ALTER TABLE `employmentType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `jobApplicationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `job_industries`
--
ALTER TABLE `job_industries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_levels`
--
ALTER TABLE `job_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job_titles`
--
ALTER TABLE `job_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posted_jobs`
--
ALTER TABLE `posted_jobs`
  MODIFY `jobId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_ibfk_1` FOREIGN KEY (`candidateId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `job_applications_ibfk_2` FOREIGN KEY (`posted_jobId`) REFERENCES `posted_jobs` (`jobId`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_jobLocation` FOREIGN KEY (`preferredJobLocation_id`) REFERENCES `counties` (`id`),
  ADD CONSTRAINT `fk_jobTitle` FOREIGN KEY (`preferredJobTitle_id`) REFERENCES `job_titles` (`id`),
  ADD CONSTRAINT `fk_location` FOREIGN KEY (`location_id`) REFERENCES `counties` (`id`),
  ADD CONSTRAINT `fk_preferredJobLocation_id` FOREIGN KEY (`preferredJobLocation_id`) REFERENCES `counties` (`id`),
  ADD CONSTRAINT `fk_preferredJobTitle_id` FOREIGN KEY (`preferredJobTitle_id`) REFERENCES `job_titles` (`id`),
  ADD CONSTRAINT `fk_skills` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
