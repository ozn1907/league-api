# League of Legends Laravel Project

This Laravel project is created using the Riot API and the Data Dragon Riot API. The aim of this project is to enhance my personal development in Laravel while working on an application for the game League of Legends, which I enjoy playing during my free time.

## Features

1. **Summoner Profile**: View detailed information about a Summoner, such as their level, icon, and most played champions.

2. **Free Champion Rotation**: Discover which champions are currently available in the free rotation, allowing players to easily try out new champions.

3. **Search Functionality**: Search the database to quickly find Summoners and their associated information.

4. **Favorite Section**: Add your favorite Summoners to a special section for quick and easy access.

## Prerequisites

Before using this project, make sure you have the following:

- **Riot Account**: You need a Riot Games account to access the Riot API. If you don't have one, you can create an account on the [Riot Games website](https://signup.na.leagueoflegends.com/).

- **API Key**: Obtain a Riot API key from the [Riot Developer Portal](https://developer.riotgames.com/). This key is necessary for making requests to the Riot API.

## Environment Configuration

Update your `.env` file with the following configuration. Adjust the `RIOT_API_KEY` to your Riot API key, and set `RIOT_API_BASE_URL` based on your region. The `DATA_DRAGON_BASE_URL` is the base URL for the Data Dragon API, and `DEFAULT_VERSION` is the version of the Data Dragon API.

```env
RIOT_API_KEY="your-riot-api-key"
RIOT_API_BASE_URL=https://your-region.api.riotgames.com
DATA_DRAGON_BASE_URL=https://ddragon.leagueoflegends.com
DEFAULT_VERSION=13.24.1
```

## Installation
1. Clone the repository to your local machine.

   ```bash
   git clone https://github.com/ozn1907/league-api.git

2. Navigate to the project directory.

   ```bash
   cd league-api

3. Install the required dependencies.
   ```bash
    composer install

4. Install the required dependencies.
   ```bash
    npm install

5. Build the project.
   ```bash
    npm run dev

6. Copy the **.env.example** file to **.env** and configure the database settings.
   ```bash
    cp .env.example .env

7. Generate an application key.
   ```bash
    php artisan key:generate

8. Database password to be entered in the .env file
   ```bash
    DB_PASSWORD=your-database-password

9. Run the database migrations.
   ```bash
    php artisan migrate

10. Start the development server.
    ```bash
    php artisan serve
