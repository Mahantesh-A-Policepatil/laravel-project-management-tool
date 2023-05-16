
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
 
    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">
 
    <style type="text/css">
        html, body{
            height:100%;
            padding:0px;
            margin:0px;
            overflow: hidden;
        }

    </style>
</head>
<body>
<div id="gantt_here" style='width:100%; height:100%;'></div>
<script type="text/javascript">
    
    gantt.config.order_branch = true;
    gantt.config.order_branch_free = true;
    
    gantt.init("gantt_here");
    gantt.config.date_format = "%Y-%m-%d %H:%i:%s"; 
    gantt.config.columns =  [        
        {name:"text",       label:"Task name",  tree:true, width: 150 },
        {name:"start_date", label:"Start time", align:"center", width: 80 },
        {name:"progress",   label:"Progress",   align:"center", width: 80 },
        {name:"duration",   label:"duration",   align:"center", width: 80 },  
        {name : "add", label:""},
    ];
       
    gantt.init("gantt_here"); 
    gantt.load("/api/ganttdata");
    console.log(gantt);
 
    var dp = new gantt.dataProcessor("/api/");
    dp.init(gantt);
    dp.setTransactionMode("REST");
</script>
</body>