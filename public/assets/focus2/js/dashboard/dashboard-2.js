(function ($) {
    "use strict";
  
    $.ajax({
      url: "/api/v1/transactions/chartmonthgraph",
      method: "GET",
      success: function (response) {
  
        const months = [];
        const paid = [];
        const pending = [];
        const canceled = [];
  
        response.data.forEach((item) => {
          months.push(item.month);
          paid.push(item.paid);
          pending.push(item.pending);
          canceled.push(item.canceled);
        });
  
        // Chart Bar
        const chartData = {
          labels: months,
          series: [paid, pending, canceled],
        };
  
        // Hitung nilai maksimal di tiap bulan
        const maxPerMonth = response.data.map((item) =>
          Math.max(item.paid, item.pending, item.canceled)
        );
        const maxDataValue = Math.max(...maxPerMonth);
  
        // Sesuaikan jarak bar chart
        let seriesBarDistance;
        if (maxDataValue >= 100) {
          seriesBarDistance = 5;
        } else if (maxDataValue >= 50) {
          seriesBarDistance = 10;
        } else {
          seriesBarDistance = 20;
        }
  
        const options = {
          seriesBarDistance: seriesBarDistance,
        };
  
        const responsiveOptions = [
          [
            "screen and (max-width: 720px)",
            {
              seriesBarDistance: 5,
              axisX: {
                labelInterpolationFnc: function (value) {
                  return value[0];
                },
              },
            },
          ],
        ];
  
        new Chartist.Bar(".ct-bar-chart", chartData, options, responsiveOptions);
  
        // ==== Pie Chart ====
  
        // Jumlahkan total Paid, Pending, dan Canceled
        const totalPaid = paid.reduce((a, b) => a + b, 0);
        const totalPending = pending.reduce((a, b) => a + b, 0);
        const totalCanceled = canceled.reduce((a, b) => a + b, 0);
  
        const pieData = {
          labels: ["Paid", "Pending", "Canceled"],
          series: [
            {
              value: totalPaid,
              className: "bg-facebook",
            },
            {
              value: totalPending,
              className: "bg-twitter",
            },
            {
              value: totalCanceled,
              className: "bg-youtube",
            },
          ],
        };
  
        const pieOptions = {
          labelInterpolationFnc: function (value) {
            return value;
          },
        };
  
        const pieResponsiveOptions = [
          [
            "screen and (min-width: 320px)",
            {
              chartPadding: 30,
              labelOffset: 100,
              labelDirection: "explode",
              labelInterpolationFnc: function (value) {
                return value;
              },
            },
          ],
          [
            "screen and (min-width: 1024px)",
            {
              labelOffset: 80,
              chartPadding: 20,
            },
          ],
        ];
  
        new Chartist.Pie(
          ".ct-pie-chart",
          pieData,
          pieOptions,
          pieResponsiveOptions
        );
      },
      error: function (err) {
        console.error("Gagal ambil data chart bulanan:", err);
      },
    });
  
    // Optional: scrollbar custom
    const wt2 = new PerfectScrollbar(".widget-todo2");
  })(jQuery);
  