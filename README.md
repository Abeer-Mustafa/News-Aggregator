
# **News Aggregator API Documentation**

## **Project Overview**

The **News Aggregator API** is a backend system built with Laravel that aggregates news articles from multiple sources, processes them, and serves them to a frontend application via API endpoints. It provides filtering, searching, and live updates for news articles. 

### **Key Features**
- Aggregates news from **News API (newsapi.org)**, **The Guardian**, and **The New York Times**.
- Allows filtering by author, category, and source.
- Supports full-text search in article titles and description.
- Uses queues for asynchronous fetching and processing of news.
- Includes live updates using **Laravel Scheduler** and **Pusher**.

---

## **News Sources**
1. **News API (newsapi.org)**: A free API for breaking news and headlines across various categories.
2. **The Guardian**: Provides access to Guardian articles with filtering capabilities.
3. **The New York Times**: Offers news content with detailed metadata.

> **Note:** These APIs have request limits for free developer accounts. You may encounter rate limit errors during high usage.

---

## **API Endpoints**

### **1. Get Articles**
Retrieve a list of articles with optional filters and search parameters.

#### **Endpoint**
```
GET /api/articles
```

#### **Query Parameters**

| Parameter    | Type    | Required | Description                                                                     | Example                       |
|--------------|---------|----------|---------------------------------------------------------------------------------|-------------------------------|
| `news-source`| String  | No       | Search for articles by news-source (values are: NewsOrg, TheGuardian, NYTimes). | `news-source=NYTimes`         |
| `q`          | String  | No       | Search for articles by title or description.                                    | `q=breaking news`        |
| `author`     | String  | No       | Filter articles by author name.                                                 | `author=John Doe`             |
| `category`   | String  | No       | Filter articles by category.                                                    | `category=Technology`         |
| `source`     | String  | No       | Filter articles by source.                                                      | `source=bbc-news`                |
| `date`       | Date    | No       | Filter articles by publish date.                                                | `date=2024-12-02`                |
| `start`      | Integer | No       | Specify the page number for paginated results. Defaults to 1.                   | `start=2`                     |
| `length`     | Integer | No       | Number of articles per page. Defaults to 10.                                    | `length=5`                    |

---

#### **Example Request**

```http
GET /api/articles?news-source=NYTimes&q=tech&author=Jane&category=Technology&source=bbc-news&date=2024-12-02
```

---

#### **Response Example**

**Status Code**: `200 OK`

```json
{
   "succss": true,
   "recordsTotal": 1,
   "data": [
      {
         "id": 1,
         "news_api": "NYTimes",
         "url": "https://www.nytimes.com/2024/12/01/books/review/apartment-women-gu-byeong-mo.html",
         "category": "Books",
         "source": "The New York Times",
         "author": "Marie-Helene Bertino",
         "title": "Subsidized Housing With a Wait List, and a Catch",
         "description": "The South Korean writer Gu Byeong-Mo’s novel “Apartment Women” imagines a commune of young families with a short fuse.",
         "date": "2024-12-01 10:00:05"
      }
   ]
}
```

#### **Error Responses**
- **500 Internal Server Error**: Server-related issues.

---

## **Installation and Setup**

### **1. Clone the Repository**
```bash
git clone https://github.com/your-repository.git
cd your-repository
```

### **2. Install Dependencies**
```bash
composer install
```

### **3. Configure the Environment**
Copy the `.env.example` file to `.env` and update the necessary configurations:
- Database connection (`DB_` settings).
- API keys for `NEWS_API`, `GUARDIAN_API`, and `NY_TIMES_API`.

### **4. Run Migrations**
Set up the database schema:
```bash
php artisan migrate
```

### **5. Queue and Scheduler Setup**
#### **Queue Worker**
Start the queue worker to handle jobs for fetching and processing news:
```bash
php artisan queue:work
```

#### **Scheduler**
Ensure the Laravel scheduler is running to trigger periodic updates:
```bash
php artisan schedule:run
```
> **Note:** In production, set up a cron job for the scheduler:
```bash
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```

### **6. Serve the Application**
Run the Laravel development server:
```bash
php artisan serve
```

---

## **Live Updates with Pusher**
- Live updates using **Pusher**.
- Configure the `.env` file with your Pusher credentials:
  ```env
  PUSHER_APP_ID=your_app_id
  PUSHER_APP_KEY=your_app_key
  PUSHER_APP_SECRET=your_app_secret
  PUSHER_APP_CLUSTER=your_app_cluster
  ```
- Events are broadcasted when new articles are fetched.

---

## **Key Notes**
- **Rate Limits**: The free developer accounts for APIs used in this project are limited. Monitor usage carefully.
- **Extensibility**: Add more sources easily by implementing new service classes that adhere to the existing design pattern.
- **Testing**: Test the API with tools like Postman.

---

## **Example Workflow**
1. The scheduler runs periodically to check for new articles.
2. If new articles are detected, jobs are queued to fetch and store them.
3. Frontend clients can call the `/api/articles` endpoint to retrieve and display the latest articles.
