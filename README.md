# AI Quiz App

Automatically generates customizable quizzes using generative-ai (Google AI Studio).

## Features

- **AI Quiz Generation**: Generate quizzes automatically using Google AI Studio, with options to customize difficulty, number of questions, and depth level.
- **Quiz Management**: Full CRUD operations for quizzes and questions, with configurable quiz rules (e.g., time limits, shuffling).
- **Real-Time Assessment**: Interactive quiz-taking interface with automated scoring and historical attempt tracking.

## Getting Started

Follow these instructions to set up the project locally.

### Prerequisites

- [Laravel](https://laravel.com/docs/installation)
- [Composer](https://getcomposer.org/) (for Laravel dependencies)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Anurag-Keshri/ai-quiz-app.git
   ```

2. **Frontend Setup (Laravel):**
   - Navigate to the `ai-quiz-app` directory:
     ```bash
     cd ai-quiz-app
     ```
   - Install dependencies:
     ```bash
     composer install
     ```
   - Update environment variables in `.env` as needed and setup the database: [Configuration](#configuration).
   - Migrate the database:
     ```bash
     php artisan migrate
     ```

3. **Backend Setup (API):**
	- Clone the repository:
	  ```bash
	  git clone https://github.com/Anurag-Keshri/ai-quiz-api.git
	  ```
	- Follow the instructions in the readme file to set up the API.

4. **Start the Development Servers:**
   - Start the frontend:
     ```bash
     php artisan serve
	 npm run dev
     ```
   - Start the backend(API):
     ```bash
     npm run dev
     ```

## Configuration

Configure your environment variables in the `.env` file:
- **AI_QUIZ_API_KEY**: API key for backend(API).
- **AI_QUIZ_API_URL**: URL for the backend(API).
- **DB_CONNECTION**: Database connection type (eg. pgsql).
- **DB_HOST**: Database host (eg. 127.0.0.1).
- **DB_PORT**: Database port (eg. 5432).
- **DB_DATABASE**: Database name.
- **DB_USERNAME**: Database username.
- **DB_PASSWORD**: Database password.

## Architecture

The AI Quiz App follows a layered architecture, designed for scalability and adaptability.

- **Frontend (App)**: Built with Laravel, Blade and styled with DaisyUI.
- **Backend (Api)**: Node.js and Express.js with Typescript backend with RESTful API design, connecting to Google AI Studio.
- **Database**: Uses PostgreSQL as the database.

## Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository.
2. Create a feature branch: `git checkout -b feature/your-feature-name`.
3. Commit your changes: `git commit -m 'Add some feature'`.
4. Push to the branch: `git push origin feature/your-feature-name`.
5. Create a new Pull Request.

## License

Distributed under the MIT License. See `LICENSE` for more information.

## Contact

For questions, suggestions, or feedback, please reach out:
- **Email**: anuragkeshri47@gmail.com	
- **GitHub**: [Anurag-Keshri](https://github.com/Anurag-Keshri)
