SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Структура таблиці `api_change_criteria`
--

CREATE TABLE `api_change_criteria` (
  `id` int NOT NULL,
  `api_params_id` int NOT NULL,
  `criteria` text NOT NULL,
  `changes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `api_change_criteria`
--

INSERT INTO `api_change_criteria` (`id`, `api_params_id`, `criteria`, `changes`) VALUES
(1, 1, '{\r\n  \"order_type\": 1,\r\n  \"additional\": {\r\n    \"custom_field_13\": \"test2\"\r\n  }\r\n}', '{\r\n  \"matched_status\": \"processed\",\r\n  \"not_matched_status\": \"confirmed\"\r\n}'),
(2, 1, '{\r\n  \"order_type\": 2,\r\n  \"additional\": {\r\n    \"custom_field_10\": \"100.00\"\r\n  }\r\n}', '{\r\n  \"matched_status\": \"processed\",\r\n  \"not_matched_status\": \"product_selection_interest\"\r\n}');

-- --------------------------------------------------------

--
-- Структура таблиці `api_params`
--

CREATE TABLE `api_params` (
  `id` int NOT NULL,
  `type` varchar(80) NOT NULL,
  `params` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `api_params`
--

INSERT INTO `api_params` (`id`, `type`, `params`) VALUES
(1, 'Asteril/Orders', '{\r\n  \"orderStatus\": 2\r\n}');

-- --------------------------------------------------------

--
-- Структура таблиці `api_settings`
--

CREATE TABLE `api_settings` (
  `id` int NOT NULL,
  `api_id` int NOT NULL,
  `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `api_settings`
--

INSERT INTO `api_settings` (`id`, `api_id`, `settings`) VALUES
(1, 1, '{\r\n  \"subdomain\": \"crm2201053\",\r\n  \"apiKey\": \"893c1e43abf6e5a60d0a964163b48554bb789540\",\r\n  \"apiGetOrdersUrl\": \"api/v3.1/orders\",\r\n  \"apiUpdateOrderUrl\": \"api/v3.1/order\"\r\n}');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `api_change_criteria`
--
ALTER TABLE `api_change_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `api_params`
--
ALTER TABLE `api_params`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `api_settings`
--
ALTER TABLE `api_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `api_change_criteria`
--
ALTER TABLE `api_change_criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблиці `api_params`
--
ALTER TABLE `api_params`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `api_settings`
--
ALTER TABLE `api_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
