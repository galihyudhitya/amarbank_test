<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Technical Test Amar Bank</title>
</head>
<body>
    <h1>Loan User Form</h1>
</body>
</html>

<table>
    <form action="/inputloan/" method="POST">
        <tr>
            <td>Name</td>
            <td>: <input type="text" name="name"></td>
        </tr>
        <tr>
            <td>KTP</td>
            <td>: <input type="text" name="ktp" pattern="[0-9]{16}"></td>
        </tr>
        <tr>
            <td>Loan Amount</td>
            <td>: <input type="number" name="loan_amount"></td>
        </tr>
        <tr>
            <td>Loan Period (in month)</td>
            <td>: <input type="number" name="loan_period"></td>
        </tr>
        <tr>
            <td>Loan Purpose</td>
            <td>: <input type="text" name="loan_purpose"></td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td>: <input type="date" name="birth_date"></td>
        </tr>
        <tr>
            <td>Sex</td>
            <td>: <input type="radio" name="sex" value="M">Male<input type="radio" name="sex" value="F">Female</td>
        </tr>
        <tr>
            <td></td>
            <td>&nbsp;&nbsp;<button>Submit</button></td>
        </tr>
    </form>
</table>

