thsplitlib
==========

Lib ตัดคำภาษาไทย สำหรับ PHP

How to use
==========


  include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'THSplitLib/segment.php');

  $segment = new Segment();

  $result = $segment->get_segment_array("คำที่ต้องการตัด");

  echo implode(' | ', $result);
  
  จะได้ Output คือ คำ | ที่ | ต้องการ | ตัด


ส่วนนี้ขออนุณาติปรับเข้าไปใส่ใน Composer นะครับ 


```php
use thsplitlib\Segment;

require 'vendor/autoload.php';

$data = Segment();

$data->get_segment_array($text_to_segment);


```

