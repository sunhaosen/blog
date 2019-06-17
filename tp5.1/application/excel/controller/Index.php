<?php
namespace app\excel\controller;

use app\excel\XLSXWriter;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        $writer = new XLSXWriter();
        //文件名
        $filename = "phone.xlsx";
//设置 header，用于浏览器下载
        header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $string = Db::table('phone')->all();
        //每列的标题头
        $title = array (
            0 => 'id',
            1 => '手机号',
        );
        //工作簿名称
        $sheet1 = 'sheet1';
        //对每列指定数据类型，对应单元格的数据类型
        foreach ($title as $key => $item){
            $col_style[] = $key ==1 ? 'int': 'string';
        }
        //设置列格式，suppress_row: 去掉会多出一行数据；widths: 指定每列宽度
        $writer->writeSheetHeader($sheet1, $col_style, ['suppress_row'=>true,'widths'=>[20,20]] );
        //写入第二行的数据，顺便指定样式
        $writer->writeSheetRow($sheet1, ['phone'],
            ['height'=>32,'font-size'=>20,'font-style'=>'bold','halign'=>'center','valign'=>'center']);
        $styles1 = array( 'font'=>'宋体','font-size'=>10,'font-style'=>'bold', 'fill'=>'#eee',
            'halign'=>'center', 'border'=>'left,right,top,bottom');
        $writer->writeSheetRow($sheet1, $title,$styles1);
        foreach ($data as $value) {
            foreach ($value as $item) {  $temp[] = $item;}
            $rows[] = $temp;
            unset($temp);
        }
        $styles2 = ['height'=>16];
        foreach($rows as $row){
            $writer->writeSheetRow($sheet1, $row,$styles2);
        }
        //合并单元格，第一行的大标题需要合并单元格
        $writer->markMergedCell($sheet1, $start_row=0, $start_col=0, $end_row=0, $end_col=7);
//输出文档
        $writer->writeToStdOut();
        exit(0);
    }
}