# ❤️ Twixitter – Like/Unlike Feature

This version of Twixitter introduces a Like/Unlike feature that allows authenticated users to interact with posts and keep track of their liked content.

---

## 🧩 Feature Overview

Users can:
- Like or Unlike any post
- View total number of likes on each post
- See all the posts they've liked

---

## 🛠️ Database Changes

- Created a new table: `likes`
  - Fields: id (primary key), `account_id` (FK), `post_id` (FK)
  - Constraints:
    - `UNIQUE(account_id, post_id)` to avoid duplicates
    - `ON DELETE CASCADE` on both foreign keys

---

## 🔧 New Functions in `functions.php`

- `getLikeCount($post_id)` – Count likes for a post
- `hasLiked($account_id, $post_id)` – Check if a user liked a post
- `likePost($account_id, $post_id)` – Add a like
- `unlikePost($account_id, $post_id)` – Remove a like
- `getLikedPosts($account_id)` – List posts liked by the user
- Updated `createPostsList()` to show Like/Unlike links and like count

---

## 🖼️ View & Controller Updates

- `liked_posts.php`: Displays all liked posts
- Updated navigation menu (`header.php`) to include "Liked Posts"

---

## 🧠 Challenge

Faced foreign key constraint errors when deleting liked posts. Fixed by using `ON DELETE CASCADE`.

---

## 👤 Author

**Manjoban Singh**  
📧 manjobanrehal29@gmail.com  
🔗 [LinkedIn](https://www.linkedin.com/in/manjobansingh1329)
