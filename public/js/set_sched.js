$(function () {
  let sched = $("#sched-form");
  let openSchedBtn = $("#set-sched");
  let closeSchedBtn = $("#close-sched-modal");

  sched.on("submit", function (e) {
    e.preventDefault();

    $.post("../../src/set_sched.php", sched.serialize(), function (r) {
      if (r !== "success") {
        alert("Error server");
        return;
      }
      alert("Saved successfully!");
      sched[0].reset();
    });
  });

  openSchedBtn.on("click", function () {
    $("#sched-modal").addClass("grid").removeClass("hidden");
  });

  closeSchedBtn.on("click", function () {
    $("#sched-modal").addClass("hidden").removeClass("grid");
  });
});
