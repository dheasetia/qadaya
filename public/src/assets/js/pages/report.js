window.addEventListener("load", function(){
  try {

    getcorkThemeObject = localStorage.getItem("theme");
    getParseObject = JSON.parse(getcorkThemeObject)
    ParsedObject = getParseObject;

    if (ParsedObject.settings.layout.darkMode) {

      var Theme = 'dark';

      Apex.tooltip = {
          theme: Theme
      }



      /*
          ==================================
              Sales By Category | Options
          ==================================
      */
      var options = {
          chart: {
              type: 'donut',
              width: 370,
              height: 430
          },
          colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
          dataLabels: {
            enabled: false
          },
          legend: {
              position: 'bottom',
              horizontalAlign: 'center',
              fontSize: '14px',
              markers: {
                width: 10,
                height: 10,
                offsetX: -5,
                offsetY: 0
              },
              itemMargin: {
                horizontal: 10,
                vertical: 30
              }
          },
          plotOptions: {
            pie: {
              donut: {
                size: '75%',
                background: 'transparent',
                labels: {
                  show: true,
                  name: {
                    show: true,
                    fontSize: '29px',
                    fontFamily: 'Nunito, sans-serif',
                    color: undefined,
                    offsetY: -10
                  },
                  value: {
                    show: true,
                    fontSize: '26px',
                    fontFamily: 'Nunito, sans-serif',
                    color: '#bfc9d4',
                    offsetY: 16,
                    formatter: function (val) {
                      return val
                    }
                  },
                  total: {
                    show: true,
                    showAlways: true,
                    label: 'إجمالي القضايا',
                    color: '#888ea8',
                    fontSize: '30px',
                    formatter: function (w) {
                      return w.globals.seriesTotals.reduce( function(a, b) {
                        return a + b
                      }, 0)
                    }
                  }
                }
              }
            }
          },
          stroke: {
            show: true,
            width: 15,
            colors: '#0e1726'
          },
          series: [985, 200],
          labels: ['سليمة', 'قيد النظر'],

          responsive: [
            {
              breakpoint: 1440, options: {
                chart: {
                  width: 325
                },
              }
            },
            {
              breakpoint: 1199, options: {
                chart: {
                  width: 380
                },
              }
            },
            {
              breakpoint: 575, options: {
                chart: {
                  width: 320
                },
              }
            },
          ],
      }

    } else {


      var Theme = 'dark';

      Apex.tooltip = {
          theme: Theme
      }

        /*
       ==================================
           Sales By Category | Options
       ==================================
   */
        var options = {
            chart: {
                type: 'donut',
                width: 370,
                height: 430
            },
            colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '14px',
                markers: {
                    width: 10,
                    height: 10,
                    offsetX: -5,
                    offsetY: 0
                },
                itemMargin: {
                    horizontal: 10,
                    vertical: 30
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '29px',
                                fontFamily: 'Nunito, sans-serif',
                                color: undefined,
                                offsetY: -10
                            },
                            value: {
                                show: true,
                                fontSize: '26px',
                                fontFamily: 'Nunito, sans-serif',
                                color: '#0e1726',
                                offsetY: 16,
                                formatter: function (val) {
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                color: '#888ea8',
                                fontSize: '30px',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce( function(a, b) {
                                        return a + b
                                    }, 0)
                                }
                            }
                        }
                    }
                }
            },
            stroke: {
                show: true,
                width: 15,
                colors: '#fff'
            },
            series: [985, 737, 270],
            labels: ['Apparel', 'Sports', 'Others'],

            responsive: [
                {
                    breakpoint: 1440, options: {
                        chart: {
                            width: 325
                        },
                    }
                },
                {
                    breakpoint: 1199, options: {
                        chart: {
                            width: 380
                        },
                    }
                },
                {
                    breakpoint: 575, options: {
                        chart: {
                            width: 320
                        },
                    }
                },
            ],
        }
    }


/*
      =================================
          Sales By Category | Render
      =================================
  */
  var chart = new ApexCharts(
      document.querySelector("#under_consideration_donut_chart"),
      options
  );

  chart.render();



  /**
     * =================================================================================================
     * |     @Re_Render | Re render all the necessary JS when clicked to switch/toggle theme           |
     * =================================================================================================
     */

  document.querySelector('.theme-toggle').addEventListener('click', function() {

    // console.log(localStorage);

    getcorkThemeObject = localStorage.getItem("theme");
    getParseObject = JSON.parse(getcorkThemeObject)
    ParsedObject = getParseObject;

    if (ParsedObject.settings.layout.darkMode) {


      /*
      ==================================
          Sales By Category | Options
      ==================================
      */

      chart.updateOptions({
        stroke: {
          colors: '#0e1726'
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                value: {
                  color: '#bfc9d4'
                }
              }
            }
          }
        }
      })


      /*
      ==================================
          Sales By Category | Options
      ==================================
      */

      chart.updateOptions({
        stroke: {
          colors: '#fff'
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                value: {
                  color: '#0e1726'
                }
              }
            }
          }
        }
      })


      /*
          =============================
              Total Orders | Options
          =============================
      */

      d_2C_2.updateOptions({
        fill: {
          type:"gradient",
          opacity: 0.9,
          gradient: {
              type: "vertical",
              shadeIntensity: 1,
              inverseColors: !1,
              opacityFrom: .45,
              opacityTo: 0.1,
              stops: [100, 100]
          }
        }
      })


    }

  })


  } catch(e) {
      console.log(e);
  }

})
