<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json;charset=utf-8');
//https://jsonlint.com/
//https://www.functions-online.com/json_decode.html
echo <<<EOL
{
  "status": "success",
  "message": "List of Countries",
  "result": {
    "countries": [
      {
        "id": 1,
        "name": "India",
        "region": "Asia"
      },
      {
        "id": 2,
        "name": "China",
        "region": "Asia"
      },
      {
        "id": 3,
        "name": "France",
        "region": "Europe"
      },
      {
        "id": 4,
        "name": "Italy",
        "region": "Europe"
      },
      {
        "id": 5,
        "name": "Germany",
        "region": "Europe"
      },
      {
        "id": 6,
        "name": "Spain",
        "region": "Europe"
      }
    ]
  }
}
EOL;
?>