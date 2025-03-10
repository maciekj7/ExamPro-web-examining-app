**Exampro** is a PHP application for creating, conducting, and grading tests. The application was developed using **XAMPP** and **Visual Studio Code**. Before running it, you need to seed the database using the included file.  

### **Login**  
After launching the application, you will see the login screen. You must enter your previously provided credentials in the appropriate fields. You cannot create a new user yourself. After logging in, you will see different options depending on the type of account you log into.  

### **Student Account**  
After logging into a student account, you will see a page with an **exam search bar**. Enter the **test code** provided by the exam creator in the designated field.  
**Note:** Once the test is found, the timer will start immediately.  

#### **Taking a Test**  
After starting the test, the first question will appear. Select your answer and click the button in the **bottom right corner** to proceed. After answering all questions, click the **Finish Exam** button.  

### **Teacher Account**  
After logging into a teacher account, you will see three options:  
- **Manage Exams**  
- **Add Exam**  
- **Check Results**  

#### **Add Exam**  
After selecting **Add Exam**, you will see a form with fields for the **Exam Name, Code,** and **Duration**. Make sure to fill out these fields.  
**Note:** The code must be a six-character string, and the maximum time limit is **60 minutes**.  

Below, you will find a section for creating questions.  
1. Enter the **question text** on the first line.  
2. The second line contains the **correct answer**.  
3. The next three lines contain **incorrect answers**.  

**Important:** When students take the test, the question order will be randomized.  

To add the next question, click **Save Question** and then the arrow in the bottom right corner.  
- If you are not satisfied with a saved question, click **Delete Question**.  
- To save the exam, click the **Save Exam** button.  

Once saved, the exam is ready for students to take!  
**Note:** Ensure that you see a **confirmation message** after saving the exam. If not, an error may have occurred, and the test was not saved.  

#### **Manage Exams**  
Selecting this option will display a list of previously created tests, showing their **Name, Code,** and **Number of Questions**.  
You can:  
- **Delete a test**  
- **Edit a test**  

When editing a test, you will see a list of questions and answers. You can modify individual questions or add new ones (**see: Add Exam**).  
To return to the menu, click **Back to Menu**.  

#### **Check Results**  
This section displays a list of created tests. Click **Show Results** to view detailed scores.  
- Click **Back to Tests** to return to the test list.  
- Click **Back to Menu** to return to the main menu.  

### **Logout**  
After finishing your work, log out using the button in the **top right corner**.
