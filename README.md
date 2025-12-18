<h1 align="center">☕ Cloud-Native Cafe Management System</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Serverless-AWS_Lambda-orange?style=for-the-badge&logo=amazonaws" />
  <img src="https://img.shields.io/badge/PHP-Backend-purple?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/Payments-Cashfree-green?style=for-the-badge" />
</p>

<p align="center">
  <b>A scalable, low-latency cafe ordering and payment system built using serverless AWS architecture</b>
</p>

<hr/>

<h2>📌 Overview</h2>

<p>
This project is a <b>cloud-native cafe management and ordering system</b> designed to handle
real-world ordering workloads with <b>reliable payment workflows</b>.
</p>

<p>
The frontend is built using <b>HTML, CSS, and JavaScript</b>, while the backend is implemented
in <b>PHP</b> and deployed using <b>AWS Lambda</b> to achieve a fully <b>serverless</b> architecture.
</p>

<p>
RESTful APIs are exposed via <b>AWS API Gateway</b>, with persistent data stored in
<b>AWS RDS</b>. Secure and compliant payment processing is handled using <b>Cashfree</b>.
</p>

<hr/>

<h2>✨ Key Features</h2>

<ul>
  <li><b>Serverless Backend</b> powered by AWS Lambda</li>
  <li><b>RESTful API Design</b> using API Gateway</li>
  <li><b>Secure Payment Processing</b> with Cashfree</li>
  <li><b>Low-Latency Order Management</b> using AWS RDS</li>
  <li><b>Auto-Scaling</b> during peak cafe ordering hours</li>
  <li><b>Dockerized Setup</b> for consistent local and cloud environments</li>
</ul>

<hr/>

<h2>🧱 Architecture</h2>

<ul>
  <li>Client (HTML / CSS / JavaScript)</li>
  <li>AWS API Gateway</li>
  <li>AWS Lambda (PHP backend)</li>
  <li>AWS RDS (orders & payment state)</li>
  <li>Cashfree Payment Gateway</li>
</ul>

<p><b>Request Flow:</b></p>

<pre>
Client → API Gateway → Lambda (PHP)
       → AWS RDS → Cashfree Payment
       ← Secure Callback Handling
</pre>

<hr/>

<h2>🛠️ Tech Stack</h2>

<table>
  <tr><td><b>Frontend</b></td><td>HTML, CSS, JavaScript</td></tr>
  <tr><td><b>Backend</b></td><td>PHP</td></tr>
  <tr><td><b>API Layer</b></td><td>AWS API Gateway</td></tr>
  <tr><td><b>Compute</b></td><td>AWS Lambda</td></tr>
  <tr><td><b>Database</b></td><td>AWS RDS</td></tr>
  <tr><td><b>Payments</b></td><td>Cashfree</td></tr>
  <tr><td><b>Containerization</b></td><td>Docker</td></tr>
</table>

<hr/>

<h2>⚙️ Engineering Notes</h2>

<ul>
  <li>Designed for <b>high availability</b> during peak ordering times</li>
  <li>Implemented <b>circuit-breaker logic</b> for external payment API calls</li>
  <li>Handled <b>secure payment callbacks</b> to prevent duplicate transactions</li>
  <li>Focused on <b>low-latency state management</b> for real-time order updates</li>
</ul>

<hr/>

<h2>📁 Project Structure</h2>

<pre>
cafe-management-system/
├── frontend/
│   ├── index.html
│   ├── styles.css
│   └── app.js
├── backend/
│   ├── handlers/
│   ├── services/
│   ├── config/
│   └── index.php
├── Dockerfile
├── database.sql
└── README.md
</pre>

<hr/>

<h2>🚀 Installation & Local Setup</h2>

<h3>Prerequisites</h3>
<ul>
  <li>Docker installed</li>
  <li>AWS account with Lambda & API Gateway enabled</li>
  <li>AWS RDS instance configured</li>
  <li>Cashfree merchant credentials</li>
</ul>

<h3>Local Development</h3>

<pre>
git clone &lt;repository-url&gt;
cd cafe-management-system

docker build -t cafe-system .
docker run -p 8080:8080 cafe-system
</pre>

<p>
The application will be available at:
</p>

<pre>
http://localhost:8080
</pre>

<hr/>

<h2>☁️ Deployment (AWS)</h2>

<ul>
  <li>Package the PHP backend for AWS Lambda</li>
  <li>Deploy Lambda functions</li>
  <li>Expose APIs using API Gateway</li>
  <li>Configure environment variables for RDS and Cashfree</li>
  <li>Enable secure HTTPS endpoints</li>
</ul>

<hr/>

<h2>🚦 System Characteristics</h2>

<table>
  <tr><td><b>Latency</b></td><td>Low</td></tr>
  <tr><td><b>Scalability</b></td><td>Automatic (Serverless)</td></tr>
  <tr><td><b>API Type</b></td><td>REST</td></tr>
  <tr><td><b>Availability</b></td><td>High</td></tr>
</table>

<hr/>

<h2>👤 Author</h2>

<p>
<b>Vishal Soni</b><br/>
Cloud & DevOps Engineer<br/>
Email: <a href="mailto:vishalsoni6350@gmail.com">vishalsoni6350@gmail.com</a>
</p>

<hr/>

<p align="center">
⭐ If you find this project useful, consider starring the repository.
</p>
