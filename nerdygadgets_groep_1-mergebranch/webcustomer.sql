-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 22 dec 2022 om 12:25
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nerdygadgets`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `webcustomer`
--

CREATE TABLE `webcustomer` (
  `webCustomerID` int(11) NOT NULL,
  `gast` tinyint(1) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `address2` varchar(50) NOT NULL,
  `city` text NOT NULL,
  `province` text NOT NULL,
  `zipcode` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `webcustomer`
--

INSERT INTO `webcustomer` (`webCustomerID`, `gast`, `fname`, `lname`, `email`, `password`, `address`, `address2`, `city`, `province`, `zipcode`) VALUES
(40, 0, 'Ramon', 'Kloosterman', 'ramonkloosterman2@gmail.com', '22edac9c2f46496b0f7e5b70ea15e02f23174526', 'Rutenberg', '22', 'Raalte', 'Overijssel', '8103RG'),
(41, 0, 'zadyfe@mailinator.com', 'Peter Weber', 'matefo@mailinator.com', 'f6c7baa98b19f4914ff842408a11cb2c8a83d3d4', 'Nihil nesciunt labo', 'Nemo irure iste amet', 'Architecto perferend', 'Flevoland', '67021'),
(42, 0, 'makyr@mailinator.com', 'Wyoming Avila', 'mitamab@mailinator.com', 'f6c7baa98b19f4914ff842408a11cb2c8a83d3d4', 'Non et magnam iure u', 'Incidunt eaque esse', 'Blanditiis quia aut ', 'Zuid-Holland', '23916'),
(43, 0, 'qiciryhuhi@mailinator.com', 'Ruth Talley', 'xesab@mailinator.com', 'f6c7baa98b19f4914ff842408a11cb2c8a83d3d4', 'Natus animi asperio', 'Et esse in aliqua A', 'Omnis repudiandae re', 'Noord-Brabant', '72226'),
(44, 0, 'saculebuc@mailinator.com', 'Brooke Davidson', 'xufevu@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Numquam aut nostrum ', 'Laborum Rerum sed q', 'Sed dolores culpa e', 'Kies...', '92417'),
(45, 0, 'jezurylizu@mailinator.com', 'Mason Gibson', 'mufovucijy@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Tempora dolor quia q', 'Assumenda sit praese', 'Aut cupidatat dolore', 'Groningen', '65453'),
(46, 0, 'lyvimyzito@mailinator.com', 'Lesley Hancock', 'liqaciw@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Dolorem dolor offici', 'Est ipsum ut ea fac', 'In velit iusto sed m', 'Noord-Holland', '55265'),
(47, 0, 'mobyp@mailinator.com', 'Noel Rutledge', 'jofunytalo@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Doloremque aliquam n', 'Nulla sed officiis c', 'Dignissimos quis inv', 'Kies...', '71323'),
(48, 0, 'holuqal@mailinator.com', 'Reuben Cox', 'raky@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Cupiditate harum dig', 'Harum et laboris dol', 'Tempora incididunt e', 'Flevoland', '74918'),
(49, 0, 'salify@mailinator.com', 'Octavia Cervantes', 'zolu@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Itaque hic voluptas ', 'Ipsum et aliquam qu', 'Ipsum deserunt est ', 'Utrecht', '10740'),
(50, 0, 'juvy@mailinator.com', 'Linus Wilkinson', 'wagibamos@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Aut excepturi est a', 'Non in quia ducimus', 'Aut velit enim pari', 'Flevoland', '55675'),
(51, 0, 'kigomaz@mailinator.com', 'Addison Maxwell', 'pabipaletu@mailinator.com', 'f1fe2f1a3b8deaaa4a219653480f6c3d2140b9ab', 'Ex sunt qui sed temp', 'Soluta est voluptate', 'Omnis adipisicing qu', 'Noord-Brabant', '80271'),
(52, 0, 'pesydyqapo@mailinator.com', 'Sage Tyler', 'zuqyq@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Elit qui perferendi', 'Laudantium cum illu', 'Dicta culpa iusto ut', 'Gelderland', '78376'),
(53, 0, 'zaputyqiqu@mailinator.com', 'Kane Sexton', 'meqyc@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Officia eu suscipit ', 'Nostrum ad ullam eum', 'Ea est ut eos aut a', 'Groningen', '48767'),
(54, 1, 'dovax@mailinator.com', 'Zachary Mcleod', 'gycom@mailinator.com', '', 'Facilis proident qu', 'Rerum perspiciatis ', 'In eu nisi velit ea ', 'Noord-Brabant', '65768'),
(55, 1, 'kanehemin@mailinator.com', 'Hector Vega', 'bocoqa@mailinator.com', '', 'Enim explicabo Quod', 'Est a consequatur co', 'Saepe dolores nesciu', 'Groningen', '24744'),
(56, 0, 'heluwovas@mailinator.com', 'Amal Gonzalez', 'dunebaguxy@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Ea enim non aspernat', 'Non voluptates velit', 'Distinctio Dolorum ', 'Drenthe', '27510'),
(57, 0, 'heluwovas@mailinator.com', 'Amal Gonzalez', 'dovax@mailinator.com', 'f1fe2f1a3b8deaaa4a219653480f6c3d2140b9ab', 'Ea enim non aspernat', 'Non voluptates velit', 'Distinctio Dolorum ', 'Drenthe', '27510'),
(63, 1, 'qycutedary@mailinator.com', 'Colby Estrada', 'dulede@mailinator.com', '3fdb13677b10691debb3909dd917b00ee751115a', 'Commodo aut consequu', 'Magni facere accusam', 'Incididunt nostrum s', 'Groningen', '29138'),
(64, 0, 'hopifyc@mailinator.com', 'Shay Orr', 'worama@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Dolore eum nostrum q', 'Id debitis pariatur', 'Quo nesciunt adipis', 'Drenthe', '81469'),
(65, 1, 'kudezawu@mailinator.com', 'Levi Woods', 'didogubi@mailinator.com', '', 'Et id mollit irure e', 'Delectus quos dolor', 'Quaerat molestias cu', 'Kies...', '24715'),
(66, 0, 'mybox@mailinator.com', 'Zahir Johnston', 'lufynix@mailinator.com', 'f1fe2f1a3b8deaaa4a219653480f6c3d2140b9ab', 'In repudiandae et ni', 'Est amet duis ipsa', 'Laudantium earum de', 'Gelderland', '25501');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `webcustomer`
--
ALTER TABLE `webcustomer`
  ADD PRIMARY KEY (`webCustomerID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `webcustomer`
--
ALTER TABLE `webcustomer`
  MODIFY `webCustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
