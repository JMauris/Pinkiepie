<?php include_once  '/views/header.inc'; ?>
<font size="+1"><strong><?php echo $this->vars['title']?></strong></font><hr/>
<?php

echo 'Page '.$this->vars['controller'].'/'. $this->vars['method']. ' '. 'not found';

include_once '/views/footer.inc';
