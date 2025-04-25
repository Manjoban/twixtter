# 🔍 Twixitter – Search Feature

This version of Twixitter includes advanced search capabilities that allow users to search for both usernames and posts, as well as view their previous search history.

---

## 🧩 Feature Overview

Users can:
- Search for other users by their username
- Search for posts by keyword
- View their own previous search history

---

## 🛠️ Database Changes

- Added a new table: `search_history`
  - Fields: search term, search type (user/post), timestamp
  - Foreign key linking to the `accounts` table
  - `ON DELETE CASCADE` for maintaining referential integrity

---

## 🔧 New Functions in `functions.php`

- `searchUsers($term)` – Search users by username only
- `searchPosts($term)` – Search for keywords in posts
- `saveSearchHistory($account_id, $term, $type)` – Store a search entry
- `getSearchHistory($account_id)` – Display past searches of a user
- `showResults($results, $type)` – Render results in view file

---

## 🖼️ New View Files

- `search_form.php`: Input for entering a search term
- `search_result.php`: Displays results for users and posts
- `search_history.php`: Shows user's previous searches

---

## 🧠 Challenge

It was challenging to keep the view files clean while handling both user and post results. This was solved by using the `showResults()` helper function.

---

## 👤 Author

**Manjoban Singh**  
📧 manjobanrehal29@gmail.com  
🔗 [LinkedIn](https://www.linkedin.com/in/manjobansingh1329)
