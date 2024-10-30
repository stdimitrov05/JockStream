# Joke Aggregator Library

A PHP library/package for aggregating science, tech, and programming jokes from multiple joke APIs. This library allows developers to configure and retrieve random jokes from one or more APIs in a standardized format with integrated logging support.

## Features

- **Aggregate Jokes**: Retrieve jokes from multiple APIs in a unified, normalized format.
- **Configurable Providers**: Choose and configure one or more joke API providers from a list of available APIs.
- **PSR-3 Logging**: Log all API requests and responses using any PSR-3 compliant logger.
- **Fault Tolerance**: Handles API rate limits and errors gracefully, continuing to return jokes when possible.
- **PSR-12 Compliance**: Adheres to PHP best practices and PSR-12 standards.

## Installation

Install the library via Composer:

```bash
composer require stdimitrov/jockstream
``


## Environment Configuration

Create a `.env` file in the root directory of your project and configure it with the necessary environment variables for accessing the APIs and setting up the database. Below is an example `.env` configuration:

```dotenv
# Rapid
RAPID_API_KEY=your_token

# Database Configuration
DB_PORT=3306
DB_ADAPTER=Mysql
DB_HOST=localhost
DB_USERNAME=root
DB_PASSWORD=your_password
DB_NAME=jockstream
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_0900_ai_ci
``

Use the file that is in the db folder.

