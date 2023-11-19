const filterButton = document.querySelector(".filters-button");

if (filterButton) {
  filterButton.addEventListener("click", function (event) {
    event.preventDefault();
    const questionsFilters = document.querySelector(".questions-filters");
    if (questionsFilters) {
      questionsFilters.classList.toggle("hidden");
    }
  });
}
