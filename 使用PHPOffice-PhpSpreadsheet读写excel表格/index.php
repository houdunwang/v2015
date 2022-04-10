<?php
include './vendor/autoload.php';
include 'Model.php';
/**
 * 下载excel表格
 */
$model = new Model('127.0.0.1','phpexcel','root','root');
$data = $model->query ('select * from student');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex (0);
$sheet = $spreadsheet->getActiveSheet ();


$sheet->setCellValue ('A1','编号')
	->setCellValue ('B1','用户名')
	->setCellValue ('C1','年龄')
	->setCellValue ('D1','性别')
	->setCellValue ('E1','昵称');


$sheet->fromArray ($data,null,'A2');

header ('Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header ('Content-Disposition:attachment;filename="hello.xlsx"');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter ($spreadsheet,'Xlsx');
$writer->save ('php://output');


/**
 * 读取excel数据并写入数据表
 */
//use PhpOffice\PhpSpreadsheet\IOFactory;
//$inputFillName = 'houdunren.xlsx';
//$spreadsheet = IOFactory::load ($inputFillName);
//
//$sheetData = $spreadsheet->getActiveSheet ()->rangeToArray ('B2:E13',null,true,true,true);
////echo '<pre>';
////print_r ($sheetData);die;
//$model = new Model('127.0.0.1','phpexcel','root','root');
//
//foreach ($sheetData as $k=>$v){
//	$sql = "insert into student (username,age,sex,nickname) values ('{$v['B']}',{$v['C']},'{$v['D']}','{$v['E']}')";
//	//echo '<pre>';
//	//print_r ($sql);
//	$model->exec ($sql);
//}



/**
 * 读取数据表数据并写入excel表格
 */
//$model = new Model('127.0.0.1','phpexcel','root','root');
//$data = $model->query ('select * from student');
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//$spreadsheet = new Spreadsheet();
//$spreadsheet->setActiveSheetIndex (0);
//$sheet = $spreadsheet->getActiveSheet ();
//
//
//$sheet->setCellValue ('A1','编号')
//	->setCellValue ('B1','用户名')
//	->setCellValue ('C1','年龄')
//	->setCellValue ('D1','性别')
//	->setCellValue ('E1','昵称');
//
//
//$sheet->fromArray ($data,null,'A2');
//$write = new Xlsx($spreadsheet);
//$write->save('houdunren.xlsx');

$data = [
	[
		'uid'=>1,
		'username'=>'houdunren',
		'nickname'=>'后盾人',
		'age'=>10
	],
	[
		'uid'=>2,
		'username'=>'php',
		'nickname'=>'php视频',
		'age'=>11
	],
	[
		'uid'=>3,
		'username'=>'vue',
		'nickname'=>'Vuejs',
		'age'=>10
	],
	[
		'uid'=>4,
		'username'=>'linux',
		'nickname'=>'linux视频',
		'age'=>10
	],
];

/**
 * 设置字体大小
 */
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//$spreadsheet = new Spreadsheet();
//$spreadsheet->setActiveSheetIndex (0);
//$sheet = $spreadsheet->getActiveSheet ();
//
////设置单元格列宽度
//$sheet->getColumnDimension ('B')->setWidth (15);
//$sheet->getColumnDimension ('C')->setWidth (15);
//
////设置字体大小
//$style = new \PhpOffice\PhpSpreadsheet\Style\Style();
//$style->getFont ()->setSize (30);
//$column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex (3) . 1;
//$sheet->duplicateStyle ($style,$column);
//
//$style = new \PhpOffice\PhpSpreadsheet\Style\Style();
//for ($i=0;$i<count ($data);$i++){
//	$style->getFont ()->setSize (20);
//	$column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex (3) . ($i+2);
//	$sheet->duplicateStyle ($style,$column);
//}
//
////设置字体、边框、填充颜色
//$sheet->getStyle ('A2:B5')->applyFromArray ([
//	'font' => [
//		'name' => 'Arial',//设置字体
//		'bold' => true,//强调
//		'italic' => false,//斜体
//		'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_DOUBLE,//下划线
//		'strikethrough' => false,//删除线
//		'color' => [
//			'rgb' => '808080'
//		]
//	],
//	'borders'=>[
//		'bottom'=>[
//			'borderStyle'=>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
//			'color'=>[
//				'rgb'=>'808080'
//			]
//		],
//		'left'=>[
//			'borderStyle'=>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
//			'color'=>[
//				'rgb'=>'808080'
//			]
//		],
//	],
//	'fill'=>[
//		'fillType'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
//		'color'=>[
//			'argb'=>'FFCCFFCC'
//		]
//	]
//]);
//
////设置重命名sheet
//$spreadsheet->getActiveSheet ()->setTitle ('houdunren');
////设置属性
//$spreadsheet->getProperties ()->setCreator ('后盾人')
//	->setTitle ('后盾人学生信息')
//	->setSubject ('摘要信息')
//	->setDescription ('后盾人最新课程全面更新啦')
//	->setCategory ('学生')
//	->setKeywords ('后盾人 视频 php');
//
//$sheet->setCellValue ('A1','编号')
//	->setCellValue ('B1','用户名')
//	->setCellValue ('C1','昵称')
//	->setCellValue ('D1','年龄')
//	->setCellValue ('C7','数据总数')
//	->setCellValue ('D7','=COUNT(D2:D5)')
//	->setCellValue ('C8','年龄总和')
//	->setCellValue ('D8','=SUM(D2:D5)')
//	->setCellValue ('C9','平均年龄')
//	->setCellValue ('D9','=AVERAGE(D2:D5)')
//	->setCellValue ('C10','最小年龄')
//	->setCellValue ('D10','=MIN(D2:D5)')
//	->setCellValue ('C11','最大年龄')
//	->setCellValue ('D11','=MAX(D2:D5)');
//
//$sheet->fromArray ($data,null,'A2');
//$write = new Xlsx($spreadsheet);
//$write->save('houdunren.xlsx');


/**
 * 设置单元格列宽度
 */
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//$spreadsheet = new Spreadsheet();
//$spreadsheet->setActiveSheetIndex (0);
//$sheet = $spreadsheet->getActiveSheet ();
//
////设置单元格列宽度
//$sheet->getColumnDimension ('B')->setWidth (15);
//$sheet->getColumnDimension ('C')->setWidth (15);
//
//$sheet->setCellValue ('A1','编号')
//	->setCellValue ('B1','用户名')
//	->setCellValue ('C1','昵称')
//	->setCellValue ('D1','年龄');
//
//$sheet->fromArray ($data,null,'A2');
//$write = new Xlsx($spreadsheet);
//$write->save('houdunren.xlsx');



/**
 * 读取excel内容
 */
//use PhpOffice\PhpSpreadsheet\IOFactory;
//$inputFillName = 'houdunren.xlsx';
//$spreadsheet = IOFactory::load ($inputFillName);
//
//$sheetData = $spreadsheet->getActiveSheet ()->toArray ();
//echo '<pre>';
//print_r ($sheetData);


/**
 * 批量将数据写入excel
 */
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//$spreadsheet = new Spreadsheet();
//$spreadsheet->setActiveSheetIndex (0);
//$sheet = $spreadsheet->getActiveSheet ();
//
//$sheet->setCellValue ('A1','编号')
//	->setCellValue ('B1','用户名')
//	->setCellValue ('C1','昵称')
//	->setCellValue ('D1','年龄');
//
//$sheet->fromArray ($data,null,'A2');
//$write = new Xlsx($spreadsheet);
//$write->save('houdunren.xlsx');

/**
 * 生成一个基本的excel
 */
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//$spredsheet = new Spreadsheet();
//$sheet = $spredsheet->getActiveSheet ();
//
//$sheet->setCellValue ('A1','houdunren')
//	->setCellValue ('B2','hello houdun');
//
//$writer = new Xlsx($spredsheet);
//$writer->save ('houdunren.xlsx');

/**
 * 环境检测
 */
//var_dump (PHP_VERSION);
//var_dump (extension_loaded ('zip'));
//var_dump (extension_loaded ('xml'));
//var_dump (extension_loaded ('gd'));