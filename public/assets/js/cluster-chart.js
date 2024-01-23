/**
 * Dashboard Analytics
 */

('use strict');

(function () {
  let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.white;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;

  // Total Revenue Report Chart - Bar Chart
  // --------------------------------------------------------------------
  const clusterLGAChartEl = document.querySelector('#clusterLGA'),
    clusterLGAChartOptions = {
      series: [
        {
          name: 'Total Farmers',
          data: lgaTotalFarmers
        },
        {
          name: 'Total Hectares',
          data: lgaTotalHectare
        }
      ],
      chart: {
        height: 300,
        stacked: true,
        type: 'bar',
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '60%',
          borderRadius: 12,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: [config.colors.primary, config.colors.info],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 6,
        lineCap: 'round',
        colors: [cardColor]
      },
      legend: {
        show: true,
        horizontalAlign: 'left',
        position: 'top',
        markers: {
          height: 8,
          width: 8,
          radius: 12,
          offsetX: -3
        },
        labels: {
          colors: axisColor
        },
        itemMargin: {
          horizontal: 10
        }
      },
      grid: {
        borderColor: borderColor,
        padding: {
          top: 0,
          bottom: -8,
          left: 20,
          right: 20
        }
      },
      xaxis: {
        categories: farmLGA,
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          formatter: function (value) {
            // Format the value with a thousand separator
            return value.toLocaleString();
          },
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        }
      },
      responsive: [
        {
          breakpoint: 1700,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '80%'
              }
            }
          }
        },
        {
          breakpoint: 1580,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '100%'
              }
            }
          }
        },
        {
          breakpoint: 1440,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '42%'
              }
            }
          }
        },
        {
          breakpoint: 1300,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 1200,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 1040,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 11,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 991,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '30%'
              }
            }
          }
        },
        {
          breakpoint: 840,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '35%'
              }
            }
          }
        },
        {
          breakpoint: 768,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '28%'
              }
            }
          }
        },
        {
          breakpoint: 640,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '37%'
              }
            }
          }
        },
        {
          breakpoint: 480,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '45%'
              }
            }
          }
        },
        {
          breakpoint: 420,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '52%'
              }
            }
          }
        },
        {
          breakpoint: 380,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '60%'
              }
            }
          }
        }
      ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof clusterLGAChartEl !== undefined && clusterLGAChartEl !== null) {
    const clusterLGAChart = new ApexCharts(clusterLGAChartEl, clusterLGAChartOptions);
    clusterLGAChart.render();
  }

  // Layer Control
  // --------------------------------------------------------------------
  const layerControlVar = document.getElementById('layerControl');
  if (layerControlVar) {
    const littleton = L.marker([11.4256, 9.5175]).bindPopup(
        'Birnin Kudu Zone <button class"btn btn-primary" onclick="redirectToPage(\'birnin_kudu_page.html\')">Go to Birnin Kudu</button>'
      ),
      denver = L.marker([12.4481, 10.0413]).bindPopup(
        'Hadejia Zone <button class"btn btn-primary" onclick="redirectToPage(\'hadejia_page.html\')">Go to Hadejia</button>'
      ),
      aurora = L.marker([12.6892, 9.1679]).bindPopup(
        'Gumel Zone <button class"btn btn-primary" onclick="redirectToPage(\'gumel_page.html\')">Go to Gumel</button>'
      ),
      golden = L.marker([12.6565, 8.4115]).bindPopup(
        'Kazaure Zone <button class"btn btn-primary" onclick="redirectToPage(\'kazaure_page.html\')">Go to Kazaure</button>'
      );

    const cities = L.layerGroup([littleton, denver, aurora, golden]);

    const street = L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
      maxZoom: 12
    });

    const satellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
      attribution: 'Map data &copy; <a href="https://www.google.com/">Google</a>',
      maxZoom: 12,
      subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    const layerControl = L.map('layerControl', {
      center: [12.4481, 10.0413],
      zoom: 7,
      layers: [cities, street],
      maxBounds: L.latLngBounds(L.latLng(10.5, 7.5), L.latLng(13.5, 12.5))
    });

    const baseMaps = {
      Street: street
      // Satellite: satellite

      // You can add more base map options here if needed
    };

    const overlayMaps = {
      Cities: cities
    };

    L.control.layers(baseMaps, overlayMaps).addTo(layerControl);

    // Function to redirect to a specific page
    function redirectToPage(pageUrl) {
      window.location.href = pageUrl;
    }
  }
})();
