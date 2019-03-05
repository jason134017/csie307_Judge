<?php
echo "<br>system";
$last_line = system('g++ test.cpp -o test.out -Wall', $return_var);
echo "<br>return_var:";
print_r($return_var);
echo "<br>last_line:";
print_r($last_line);

echo "<br><br>exec";
exec('g++ test.cpp -o test.out -Wall', $output, $return_var);
echo "<br>return_var:";
print_r($return_var);
echo "<br>output:";
print_r($output);

echo "<br><br>shell_exec";
$output = shell_exec('./main.out');
echo "<br>output:";
echo $output."123<br>";
print_r($output);
?>