Custom User Authentication
Custom User Authentication is a WordPress plugin that facilitates user registration, login, and OTP verification using phone numbers. It enhances user authentication with additional security measures and provides a seamless experience for managing user accounts.

Features
User Registration: Allow users to register using their email, name, phone number, and address.
OTP Verification: Securely verify user email addresses using OTP sent to registered email.
User Login: Enable users to login using their registered phone number.
Dashboard Redirection: Automatically redirect users to the WordPress dashboard upon successful login.
Customizable Styling: Easily customize button colors through the WordPress admin interface.
Installation
To install Custom User Authentication on your WordPress site, follow these steps:

Download the Plugin:
Download the plugin zip file from GitHub (https://github.com/julymoe/custom-user-auth).

Upload to WordPress:
Log in to your WordPress admin panel.
Go to Plugins > Add New.
Click on the "Upload Plugin" button.
Select the plugin zip file and upload it.

Activate the Plugin:
After uploading, click the "Activate" button to activate the Custom User Authentication plugin.

Configure Settings:
Navigate to Settings > Custom User Authentication in the WordPress admin dashboard.
Configure any settings as needed, such as button colors.

Add Shortcodes:
Use shortcodes to add registration and login forms to your site:
[cua_registration]: Renders the user registration form.
[cua_login]: Renders the user login form.

Customize Styling (Optional):
User Registration Form
To display the user registration form on a page or post, add the [cua_registration] shortcode.
Example:
[cua_registration]

User Login Form
To display the user login form, add the [cua_login] shortcode to a page or post.
Example:
[cua_login]

OTP Verification
Upon successful registration, an OTP will be sent to the user's registered email.
Users must enter the OTP in the verification form to complete the registration process.

Support
For support or issues, please contact us at athelay.lwin@gmail.com or visit my GitHub repository for bug reports and feature requests.

Contributing
Contributions are welcome! Fork the repository and submit a pull request with your enhancements.

License
This project is licensed under the MIT License.

