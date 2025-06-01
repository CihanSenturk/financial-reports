# Financial House Dashboard

This project is a web-based dashboard application developed using the Laravel framework, based on the API documentation provided by Financial House. The application is designed to visualize financial transaction data and present it in a detailed, interactive interface.

> 🌐 [Live Demo](https://cihansnturk.com/login)

## 🔧 Project Features

✅ Built with **Laravel MVC** architecture  
✅ Integrated with **5 different API endpoints**  
✅ Secure authentication using **Session + Cache**  
✅ Modern and responsive **dashboard interface**  
✅ **AJAX-based modals** for improved user experience  
✅ Supports **Unit and Feature testing**  
✅ Open source and hosted on GitHub  
✅ All necessary configuration files included for deployment

---

- **Login Page**

![image](https://github.com/user-attachments/assets/40852c7a-3ab9-4d3a-881b-a0da9036fe77)

The login form posts the user credentials to the `merchant login` API endpoint.  
If the returned status is `approved`, the user is authenticated.  
The API token is valid for 10 minutes and is cached accordingly.  
When the token expires, a custom middleware automatically fetches a new token from the API. This ensures seamless navigation for the user.

- **Dashboard Page**

![image](https://github.com/user-attachments/assets/154bdea0-e7d5-4ff6-8240-37fd04cd862e)

This page uses the `transaction report` endpoint to display data widgets.  
Supports filtering with From Date and To Date fields.  
By default, it shows the data for the current year.

- **Transaction List Page**

![image](https://github.com/user-attachments/assets/b29db3ea-1a55-4f69-92cc-b54792cd79fb)

This page uses the `transactions list` endpoint to show transactions.  
Supports filtering with From Date and To Date fields.  
By default, it lists transactions from the current year.  
Each transaction ID and Merchant column opens an AJAX-based modal.

- **Transaction Details**

![image](https://github.com/user-attachments/assets/76ffca99-ffd1-4b5a-9160-b257455acd12)

This modal displays detailed information using the `transaction` endpoint.

- **Merchant Details**

![image](https://github.com/user-attachments/assets/84cbb444-b14c-4a6a-a411-52bc81a4db14)

This modal fetches merchant information using the `client` endpoint.

---

## 🏗️ Installation

```
composer install; npm install; npm run dev
```

## 🧪 Test

```
php artisan test
```
