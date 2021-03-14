/**
  扩展cjgl模块
  **/

layui.extend({
        echarts: 'echarts/echarts'
    }).define(['echarts'], function(exports) {
  //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
  var echarts = layui.echarts;

  var obj = {

    /**
    * 异步获取图表中的数据
    *
    * @access public
    * @param id 要添加数据的div
    * @param url 异步地址
    * @param val 异步时携带的参数
    * @param val 图表标题
    * @return array 返回类型
    */
    tiaoxing:function (id, url, val, title) {
      var myTiaoxing = echarts.init(document.getElementById(id), 'infographic');
      $.post(url,val).done(function (data) {
        myTiaoxing.setOption({
          title:{
            text:title,
            left: 'center',
          },
          legend: {
            top: '10%',
          },
          grid: {
            left: '10%',
            top: '20%',
            right: '10%',
            bottom: '15%'
          },
          tooltip: {
            show: true,
            axisPointer: {
              type: 'cross'
            }
          },
          toolbox: {
            id:id,
            show:true,
            orient:'horizontal',
            showTitle:true,
            feature: {
              restore: { //重置
                show: true
              },
              saveAsImage: { //保存文件
                show: true
              },
            },
          },
          dataset: {
            source:data.data
          },
          xAxis: {
            type: 'category',
            axisLabel: {
              rotate:30
            }
          },
          yAxis: {},
          dataZoom: [
            {
              type: 'inside',
              start: 0,
              end: 100
            },
            {
              show: true,
              height: 20,
              type: 'slider',
              top: '90%',
              xAxisIndex: [0],
              start: 0,
              end: 100
            }
          ],
          series: data.series,
        });
    });
   },


   /**
    * 异步获取箱线图表中的数据
    *
    * @access public
    * @param id 要添加数据的div
    * @param url 异步地址
    * @param val 异步时携带的参数
    * @param title 图表标题
    * @return array 返回类型
    */
    xiangti:function (id, url, val, title)
    {
      $.post(url,val).done(function (data) {
       axisData = data.axisData;
       category = data.category;
       boxData = data.boxData;
       myseries = Array();

       for(var i in category)
       {
        myseries.push({
         'name':category[i],
         'type':'boxplot',
         'data':boxData[i],
         'tooltip':{formatter: formatter},
       });
      }

      // 设置初始值
      option = {
       title: {
         text: title,
         left: 'center',
       },
       legend: {
         top: '10%',
              // data:
           },
           tooltip: {
             trigger: 'item',
             axisPointer: {
               type: 'shadow'
             }
           },
           toolbox: {
            id:id,
            show:true,
            orient:'horizontal',
            showTitle:true,
            feature: {
                      restore: { //重置
                      show: true
                     },
                      saveAsImage: { //保存文件
                      show: true
                     },
                   },
                 },
                 grid: {
                   left: '10%',
                   top: '20%',
                   right: '10%',
                   bottom: '15%'
                 },
                 xAxis: {
                   type: 'category',
                   data: axisData,
                   boundaryGap: true,
                   nameGap: 30,
                   splitArea: {
                     show: true
                   },
                   axisLabel: {
                  // formatter: 'expr {value}'
               },
               splitLine: {
                 show: false
               }
             },
             yAxis: {
               type: 'value',
               name: '得分',
              // min: -400,
              // max: 600,
              splitArea: {
               show: false
             }
           },
           dataZoom: [
           {
             type: 'inside',
             start: 0,
             end: 100
           },
           {
             show: true,
             height: 20,
             type: 'slider',
             top: '90%',
             xAxisIndex: [0],
             start: 0,
             end: 100
           }
           ],
           series: myseries,
         };

         var myXiangti = echarts.init(document.getElementById(id), 'infographic');
         myXiangti.setOption(option);
       });
    },


    /**
    * 异步获取箱线图表中的数据
    *
    * @access public
    * @param id 要添加数据的div
    * @param url 异步地址
    * @param val 异步时携带的参数
    * @param title 图表标题
    * @return array 返回类型
    */
    fenshuduan: function(id, url, val, title){
      // var colors = ['#5793f3', '#d14a61', '#675bba'];
      $.post(url,val).done(function (data) {

        // 设置初始值
        option = {
          tooltip: {
            show: true,
            trigger: 'axis',
          },
          legend: {
            top: '10%',
            // data:data.legend
          },
          title: {
            text: title,
            left: 'center',
          },
          grid: {
            left: '10%',
            top: '20%',
            right: '10%',
            bottom: '15%'
          },
          toolbox: {
            id:id,
            show:true,
            orient:'horizontal',
            showTitle:true,
            feature: {
              restore: { //重置
                show: true
              },
              saveAsImage: { //保存文件
                show: true
              },
            },
          },
          xAxis: {
            type: 'category',
            boundaryGap: true,
            nameGap: 30,
            splitArea: {
              show: true
            },
            splitLine: {
              show: false
            },
            data: data.xAxis
          },
          yAxis: {
            type: 'value',
            name: '得分',
            splitArea: {
              show: false
            }
          },
          dataZoom:[
            {
              type: 'inside',
              start: 0,
              end: 100
            },
            {
              show: true,
              height: 20,
              type: 'slider',
              top: '90%',
              xAxisIndex: [0],
              start: 0,
              end: 100
            }
          ],
          series: {
            data: data.series,
            type:'line',
            // smooth: true
          },
        };

        var myFenshuduan = echarts.init(document.getElementById(id), 'infographic');
        myFenshuduan.setOption(option);
      });
    },



    formatter:function (param) {
     return [
     param.name,
     '最低分: ' + param.data[1],
     '25%: ' + param.data[2],
     '50%: ' + param.data[3],
     '75%: ' + param.data[4],
     '最高: ' + param.data[5]
     ].join('<br/>');
   },


  };
  //输出test接口
  exports('myEchart', obj);
});
