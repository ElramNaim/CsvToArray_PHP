<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function getCSVarray($csvFile, $delimiter)
    {
        if (($handle = fopen($csvFile, 'r')) !== false) {
            // Skip the header row
            $keys = fgetcsv($handle, 1000, $delimiter);
            // Read each line of the CSV file until the end
            while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $csvData[] = array_combine($keys, $data);
            }
            return $csvData;
        }
    }

    function setElement($res, $arr)
    {
        if (count($arr) == 0)
            return $res;
        $row = array_shift($arr); //each row sepertly 
        if (isset($res[$row["parent_id"]])) //parent_id exist as a key in the res array
        {
            $res[$row["parent_id"]]["dates"][$row["id"]] = $row["date"];
            //inside the parent in the array of dates , the key will be this child id ,his value the date
        } elseif (($row["parent_id"] != 0)) {
            array_push($arr, $row);
            //if child parent doesnt exist yet , push it to the array again
        } else {
            $res[$row["id"]] = array("date" => $row["date"], "dates" => []);
        } // not existed yet - so initialize the parent
        return setElement($res, $arr);
    }

    // Usage
    $csvFile = 'C:\web\php\test_file.csv.csv';
    $delimiter = ',';

    $csvData = getCSVarray($csvFile, $delimiter);

    $csvData = setElement([], $csvData);
    echo "<pre>";
    echo print_r($csvData, true);
    echo "</pre>";


    ?>
</body>

</html>