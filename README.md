# 📖 CodeNestIIT

CodeNestIIT is an exclusive interactive **coding platform** designed specifically for students of the **Institute of Information Technology (IIT) at Noakhali Science and Technology University (NSTU)**. It enhances **C programming** education by providing a structured environment for learning, practicing, and competing in coding challenges.

---

## 🚀 Features Implemented

### ✅ 1. **User Authentication with Approval System**
- New users **must be approved** by a teacher before accessing the dashboard.
- Teachers **approve/reject users** at `/teacher/approvals`.
- **Implemented in:** `AuthServiceProvider.php`, `CheckApproval Middleware`

### ✅ 2. **Problem Solving System**
- **ACE Editor** for coding in the browser.
- Submissions are **executed via JDoodle API**.
- **Test Case Validation** ensures correctness across sample & extra test cases.
- **Submission History** tracks past attempts.
- **Implemented in:** `ProblemController.php`, `show.blade.php`

### ✅ 3. **Contests & Leaderboard**
- Teachers **create contests** and set problems.
- Students **participate, solve problems, and get ranked**.
- **Leaderboard Sorting:**
  - **Primary:** Total Score
  - **Secondary:** Less Penalty Time
  - **Tertiary:** Earlier Last Accepted Submission
- **Implemented in:** `ContestController.php`, `leaderboard.blade.php`

### ✅ 4. **Test Case Validation System**
- **All test cases (sample + extra) must pass** for a correct submission.
- **Failed cases show input, expected, and actual output**.
- **Implemented in:** `ProblemController.php`, `ContestSubmissionController.php`

### ✅ 5. **Custom Input Execution**
- Users **test code with custom input** before submitting.
- **JDoodle API executes the code** and returns output.
- **Implemented in:** `runCustom()` in `ProblemController.php`

### ✅ 6. **Discussion & Comment System**
- Users **discuss problems** and **reply to comments**.
- Replies appear **in order, with a "Reply" button after the last reply**.
- **Implemented in:** `CommentController.php`, `show.blade.php`

### ✅ 7. **Contest Discussion Forum**
- Dedicated **Q&A space for contests**.
- Users **ask & reply to contest-related questions**.
- **Implemented in:** `ContestDiscussionController.php`, `discussions/index.blade.php`

### ✅ 8. **Plagiarism Detection**
- **Detects code similarity (≥ 85%)**.
- **Marks submissions as `Plagiarized`** in the leaderboard.
- **Implemented in:** `ContestSubmissionController.php`, `leaderboard.blade.php`

### ✅ 9. **User Profile & Stats**
- **Shows:**  
  ✔ **Total Contests Participated**  
  ✔ **Problems Solved in Each Contest**  
  ✔ **Submission History**  
- **Each Problem Page Shows:**  
  ✔ **Acceptance Rate**  
  ✔ **Total Submissions**  
  ✔ **Correct Submissions**  
- **Implemented in:** `UserProfileController.php`, `profile.blade.php`

### ✅ 10. **Teacher Dashboard**
- **Teachers can:**
  ✔ **Create/Edit/Delete Problems**  
  ✔ **Manage Contests**  
  ✔ **Approve Users**  
  ✔ **View Plagiarism Reports**  
- **Implemented in:** `TeacherController.php`, `teacher/dashboard.blade.php`

---

## 🖥️ Technologies Used
- **Backend:** Laravel (PHP Framework)
- **Frontend:** Blade Templates, Tailwind CSS
- **Database:** MySQL
- **Code Execution API:** JDoodle API
- **Authentication:** Middleware Approval System
- **Editor:** ACE Editor for browser-based coding
- **Plagiarism Detection:** Custom Algorithm Based on Code Similarity

---

## 🛠️ Installation & Setup  

### 1️⃣ Clone the Repository  
```bash
git clone https://github.com/yourusername/CodeNestIIT.git
cd CodeNestIIT
```

### 2️⃣ Install Dependencies  
```bash
composer install
npm install
npm run dev
```

### 3️⃣ Configure Environment  
```bash
cp .env.example .env
```
Modify `.env` file:  

```ini
APP_NAME=CodeNestIIT
APP_ENV=local
APP_KEY=base64:yourkey
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=codenest_iit
DB_USERNAME=root
DB_PASSWORD=

JDOODLE_CLIENT_ID=your_jdoodle_client_id
JDOODLE_CLIENT_SECRET=your_jdoodle_client_secret
JDOODLE_API_URL=https://api.jdoodle.com/v1/execute
```

### 4️⃣ Run Database Migrations  
```bash
php artisan migrate --seed
```

### 5️⃣ Start Development Server  
```bash
php artisan serve
```

---

## 🔗 API Reference  

### 1️⃣ Problem Submission API  
**Endpoint:**  
```http
POST /problems/{id}/submit
```
**Request Body:**  
```json
{
  "code": "#include <stdio.h> \n int main() { printf(\"Hello, World!\"); return 0; }"
}
```
**Response:**  
```json
{
  "status": "Correct",
  "output": "✅ All test cases passed"
}
```

### 2️⃣ Contest Submission API  
**Endpoint:**  
```http
POST /contests/{contest_id}/problems/{problem_id}/submit
```
**Response (Plagiarism Detected):**  
```json
{
  "status": "Plagiarized",
  "message": "⚠️ Plagiarism detected! Your submission has been flagged."
}
```

---

## 📜 Roadmap & Future Features  
- 🔲 **Live Leaderboard** – Real-time updates without refresh.  
- 🔲 **Group Contests** – Support for teams.  
- 🔲 **More Language Support** – Python, Java, JavaScript.  
- 🔲 **Advanced Plagiarism Detection** – Using AI-based similarity detection.  

---

## 🛠️ Development Commands  

### Migrate Database  
```bash
php artisan migrate --seed
```

### Clear Cache & Restart  
```bash
php artisan optimize:clear
php artisan serve
```

### Run Tests  
```bash
php artisan test
```

---
