<?php echo $header; ?>   


<?php

echo "<pre>";
print_r($this->session->user_session);
echo "</pre>";
echo "<pre>";
print_r($this->session->access_control);
echo "</pre>";


?>








<?php echo $footer; ?>