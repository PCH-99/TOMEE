-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Czas generowania: 30 Wrz 2021, 07:12
-- Wersja serwera: 10.3.16-MariaDB
-- Wersja PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `id16296605_tomee`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id_comm` int(11) NOT NULL,
  `id_author_comm` int(11) NOT NULL,
  `id_post_comm` int(11) NOT NULL,
  `content_comm` text COLLATE utf8_polish_ci NOT NULL,
  `date_comm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`id_comm`, `id_author_comm`, `id_post_comm`, `content_comm`, `date_comm`) VALUES
(54, 23, 20, ':)', '2021-04-18 17:46:11'),
(55, 32, 20, 'Suuuper', '2021-04-18 18:01:28'),
(57, 32, 21, 'Chętnie ci pomogę spalić Night City XD', '2021-04-18 19:13:50'),
(58, 31, 20, 'Dobry byłby z ciebie wiedźmin :)', '2021-04-18 19:28:05'),
(59, 31, 22, 'Ja tam wolę w Novigradzie zamieszkać.', '2021-04-18 19:38:29'),
(60, 30, 22, 'Night City jest piękniejsze ale za to o wiele bardziej niebezpieczne', '2021-04-18 19:48:10'),
(61, 30, 23, 'Na Skellige wyrosły palmy podobno XD', '2021-04-18 19:49:56'),
(62, 32, 23, 'Muszę kiedyś odwiedzić Skellige', '2021-04-18 19:59:25'),
(63, 33, 20, 'a', '2021-05-31 10:06:26'),
(64, 33, 20, '&lt;script&gt;alert();&lt;/script&gt;', '2021-05-31 10:06:31'),
(65, 33, 20, '&lt;script&gt;alert();&lt;/script&gt;', '2021-07-31 12:13:58');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `conversations`
--

CREATE TABLE `conversations` (
  `id_conv` int(11) NOT NULL,
  `id_first_user` int(11) NOT NULL,
  `id_second_user` int(11) NOT NULL,
  `date_last_active` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `conversations`
--

INSERT INTO `conversations` (`id_conv`, `id_first_user`, `id_second_user`, `date_last_active`) VALUES
(18, 23, 30, '2021-04-18 17:46:35'),
(19, 32, 30, '2021-05-01 20:21:31'),
(20, 33, 31, '2021-07-08 16:10:50'),
(21, 31, 23, '2021-06-16 08:56:34'),
(22, 33, 32, '2021-07-31 12:18:04');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `likes`
--

CREATE TABLE `likes` (
  `id_like` int(11) NOT NULL,
  `like_id_author` int(11) NOT NULL,
  `like_id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `likes`
--

INSERT INTO `likes` (`id_like`, `like_id_author`, `like_id_post`) VALUES
(95, 30, 20),
(96, 23, 21),
(97, 32, 20),
(99, 32, 22),
(101, 31, 22),
(102, 31, 23),
(105, 30, 22),
(107, 32, 21),
(108, 32, 23),
(110, 30, 23),
(113, 33, 23),
(114, 31, 21),
(115, 30, 21);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id_messg` int(11) NOT NULL,
  `id_convers` int(11) NOT NULL,
  `author_messg` int(11) NOT NULL,
  `content_messg` text COLLATE utf8_polish_ci NOT NULL,
  `date_messg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`id_messg`, `id_convers`, `author_messg`, `content_messg`, `date_messg`) VALUES
(755, 18, 23, 'heyy', '2021-04-18 17:46:35'),
(756, 19, 32, 'hiii', '2021-04-18 19:22:23'),
(757, 19, 30, 'hey wujku T', '2021-04-18 20:04:59'),
(758, 19, 30, 'xd', '2021-04-18 20:05:14'),
(759, 19, 30, 'hiii', '2021-05-01 20:20:53'),
(760, 19, 30, 'xd', '2021-05-01 20:21:21'),
(761, 19, 30, 'hihihi', '2021-05-01 20:21:31'),
(762, 20, 33, 'hbhk', '2021-06-07 11:00:10'),
(763, 20, 33, 'geralt gdzie moje potwory', '2021-06-15 12:08:00'),
(764, 20, 31, 'hey', '2021-06-15 12:11:43'),
(765, 21, 31, 'hey', '2021-06-16 08:56:34'),
(766, 20, 33, 'Cze', '2021-07-08 16:10:50'),
(767, 22, 33, 'heeey', '2021-07-31 12:17:54'),
(768, 22, 33, 'hi', '2021-07-31 12:18:04');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `observations`
--

CREATE TABLE `observations` (
  `id_obs` int(11) NOT NULL,
  `id_observer` int(11) NOT NULL,
  `id_watched` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `observations`
--

INSERT INTO `observations` (`id_obs`, `id_observer`, `id_watched`) VALUES
(82, 30, 23),
(83, 23, 30),
(84, 32, 30),
(85, 32, 23),
(86, 31, 30),
(88, 31, 32),
(89, 30, 32),
(90, 30, 31),
(91, 32, 31),
(92, 33, 23),
(94, 33, 31),
(96, 33, 32),
(97, 33, 30),
(98, 31, 23);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `author_post` text COLLATE utf8_polish_ci NOT NULL,
  `content_post` text COLLATE utf8_polish_ci NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `posts`
--

INSERT INTO `posts` (`id_post`, `author_post`, `content_post`, `date_added`) VALUES
(20, '30', 'Jak na żółtodzioba to całkiem fajny serwis zrobiłeem :)', '2021-04-18 16:12:03'),
(21, '23', 'Mamy miasto do spalenia!!!', '2021-04-18 17:44:29'),
(22, '32', 'W którym mieście chcielibyście zamieszkać: Night City czy Los Santos?', '2021-04-18 19:20:20'),
(23, '31', 'Zarazaa!!!', '2021-04-18 19:33:48');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `password` text COLLATE utf8_polish_ci NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `surname` text COLLATE utf8_polish_ci NOT NULL,
  `job` text COLLATE utf8_polish_ci NOT NULL,
  `country` text COLLATE utf8_polish_ci NOT NULL,
  `gender` text COLLATE utf8_polish_ci NOT NULL,
  `age` text COLLATE utf8_polish_ci NOT NULL,
  `live_place` text COLLATE utf8_polish_ci NOT NULL,
  `marital_status` text COLLATE utf8_polish_ci NOT NULL,
  `watching` int(11) NOT NULL,
  `followers` int(11) NOT NULL,
  `date_join` datetime NOT NULL,
  `popularity` text COLLATE utf8_polish_ci NOT NULL,
  `reported` text COLLATE utf8_polish_ci NOT NULL,
  `profile_picture` text COLLATE utf8_polish_ci NOT NULL,
  `profile_background` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `name`, `surname`, `job`, `country`, `gender`, `age`, `live_place`, `marital_status`, `watching`, `followers`, `date_join`, `popularity`, `reported`, `profile_picture`, `profile_background`) VALUES
(23, 'Johnny', '123@sdds.sdsd', '$2y$10$wgXDgCFbp04nhyQ/7JbzKOLnLNs8FZK8AR0/BtNIR.fSwh9SL.qX6', 'Johnny', 'Silverhnad', 'terrorysta-hobbysta', 'NUSA', 'mężczyzna', '33', 'Night City', 'Nie podano', 1, 4, '2021-02-25 16:33:04', 'Niska', 'Nie', 'pp23.png', 'pb23.jpg'),
(30, 'Przemek', 'xd@xd.com', '$2y$10$rzWxvpz3Kk9TEX7FwrxIOuCgQP6KkFi7xBiMDKoP9ZNk1Rr7yL0em', 'Przemysław', 'Chimiak', 'webmaster', 'POL', 'mężczyzna', '22', 'Morąg', 'kawaler', 3, 4, '2021-04-18 16:04:47', 'Niska', 'Nie', 'pp30.jpg', 'pb30.jpg'),
(31, 'Geralt', 'xddd@dd.com', '$2y$10$1DvDuUsFZtSWzHD0/EXGj.rP5YrXti/gqEit8fqQWOogvjgIiK2qO', 'Geralt', 'z Rivii', 'zabójca potworów', 'Kaedwen', 'mężczyzna', '99', 'Kaer Morhen', 'to skomplikowane', 3, 3, '2021-04-18 17:55:58', 'Niska', 'Nie', 'pp31.jpg', 'pb31.jpg'),
(32, 'Trevor', 'ssss@ssss.sss', '$2y$10$RxdeJIYxWm9WvqXd26Ao3.HsmJwe00Dlx/20ylnJCVgzu2pyFkzp.', 'Trevor', 'Phillips', 'biznesmen', 'KANADA', 'mężczyzna', '46', 'Sandy Shores', 'kawaler', 3, 3, '2021-04-18 18:00:25', 'Niska', 'Nie', 'pp32.jpg', 'pb32.jpg'),
(33, 'mega_praca', '123testowy@mail.com', '$2y$10$VwJSvCJyHOvqXdy34edU3uVqc1AqY5.GN8aP1uPS3USIIRqL0ckoK', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 4, 0, '2021-05-28 20:55:28', 'Niska', 'Nie', 'Nie podano', 'Nie podano');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comm`);

--
-- Indeksy dla tabeli `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id_conv`);

--
-- Indeksy dla tabeli `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_like`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_messg`);

--
-- Indeksy dla tabeli `observations`
--
ALTER TABLE `observations`
  ADD PRIMARY KEY (`id_obs`);

--
-- Indeksy dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT dla tabel zrzutów
--

--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT dla tabeli `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id_conv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `likes`
--
ALTER TABLE `likes`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT dla tabeli `messages`
--
ALTER TABLE `messages`
  MODIFY `id_messg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=769;

--
-- AUTO_INCREMENT dla tabeli `observations`
--
ALTER TABLE `observations`
  MODIFY `id_obs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT dla tabeli `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
