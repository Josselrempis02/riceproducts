<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="form-wrapper">
        <div class="form-side">
            <a href="#" title="Logo">
                <img class="logo" src="assets/employee.png" alt="Logo">
            </a>
            <form class="my-form" action="authenticate.php" method="post">
                <div class="login-welcome-row">
                    <h1>Hi! Welcome &#x1F44F;</h1>
                </div>
                <div class="text-field">
                    <label for="email">Email:
                        <input type="email" id="email" name="email" placeholder="Your Email" required>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                            <path
                                d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28">
                            </path>
                        </svg>
                    </label>
                </div>
                <div class="text-field">
                    <label for="password">Password:
                        <input id="password" type="password" name="password" placeholder="Your Password" required>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z">
                            </path>
                            <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
                            <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                        </svg>
                    </label>
                </div>
                <button class="my-form__button" type="submit" name="login">Login</button>

                <div class="my-form__actions">
                    <div class="my-form__row">
                        <span>Did you forget your password?</span>
                        <a href="reset_password.php" title="Reset Password">Reset Password</a>
                    </div>
                    <div class="my-form__signup">
                        <span>Don't have an account?</span>
                        <a href="registration.php" title="Register">Register here</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="info-side">
            <img src="assets/employee.png" alt="Mock" class="mockup" />
            <div class="welcome-message">
                <h2>Employee Management 👋</h2>
                <p>
                    Effortlessly oversee employee-related records and maintain organization with our Employee
                    Management System.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
