<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La liste des membres inscris</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7ff;
            padding: 20px;
            color: var(--dark);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            padding: 20px;
        }

        h1 {
            color:#f76b21;
            text-align: center;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #f76b21;
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            font-weight: 500;
        }
        .add-btn{
            background: #f76b21;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        a .add-btn {
    text-decoration: none !important;
  }
        </style>

</head>
<body>
<div class="container">
    <h1><i class="fas fa-calendar-alt"></i>Les demandes de creation des clubs</h1>
    <div class="table-container">
        <table>
            <thead>

            <tr>
                <th>Nom de club </th>
                <th>President de club</th>
                <th>description de club</th>
                
            </tr>
            </thead>
        

        </table>
        





    </div>
</div>




</body>
</html>