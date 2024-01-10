let chart;
$(function () {
  $.get(
    "../../src/get_records.php",
    { filter: "day" },
    function (data, status) {
      showDay(JSON.parse(data));
    },
  );
  $("#chart_filter").on("change", function () {
    const value = $(this).val();

    console.log(value);
    $.get(
      "../../src/get_records.php",
      { filter: value },
      function (data, status) {
        if (value === "day") {
          showDay(JSON.parse(data));
        } else if (value === "month") {
          showMonth(JSON.parse(data));
        } else {
          showYear(JSON.parse(data));
        }
      },
    );
  });
});

function showDay(data3) {
  const ctx = document.getElementById("myChart");
  const labels = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
  ];
  let dataSet = [0, 0, 0, 0, 0, 0, 0];

  for (let i = 0; i < data3.length; i++) {
    for (let j = 0; j < labels.length; j++) {
      if (data3[i].Day === labels[j]) {
        dataSet[j] = +data3[i].RecordsCount;
        break;
      }
    }
  }

  const data = {
    labels: labels,
    datasets: [{
      label: "Data",
      data: dataSet,
      fill: false,
      borderColor: "rgb(75, 192, 192)",
      tension: 0.1,
    }],
  };
  if (!chart) {
    chart = new Chart(ctx, {
      type: "line",
      data: data,
    });
    return;
  }

  chart.data = data;
  chart.update();
}
function showMonth(data3) {
  const ctx = document.getElementById("myChart");
  const labels = [
    "December",
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
  ];
  let dataSet = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

  for (let i = 0; i < data3.length; i++) {
    for (let j = 0; j < labels.length; j++) {
      if (data3[i].Month === labels[j]) {
        dataSet[j] = +data3[i].RecordsCount;
        break;
      }
    }
  }

  const data = {
    labels: labels,
    datasets: [{
      label: "Data",
      data: dataSet,
      fill: false,
      borderColor: "rgb(75, 192, 192)",
      tension: 0.1,
    }],
  };
  chart.data = data;
  chart.update()
}
function showYear(data3) {
  const ctx = document.getElementById("myChart");
  const labels = [
    "2020",
    "2021",
    "2022",
    "2023",
    "2024",
    "2025",
  ];
  let dataSet = [0, 0, 0, 0, 0, 0];

  for (let i = 0; i < data3.length; i++) {
    for (let j = 0; j < labels.length; j++) {
      if (data3[i].Year === labels[j]) {
        dataSet[j] = +data3[i].RecordsCount;
        break;
      }
    }
  }

  const data = {
    labels: labels,
    datasets: [{
      label: "Data",
      data: dataSet,
      fill: false,
      borderColor: "rgb(75, 192, 192)",
      tension: 0.1,
    }],
  };
  chart.data = data;
  chart.update()
}
