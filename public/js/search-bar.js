const searchBar = document.querySelector(".live-search");
const searchBarInfo = document.querySelector(".search-bar-info");

if (searchBar && searchBarInfo) {
  searchBar.addEventListener("click", function (event) {
    event.stopPropagation();
    searchBarInfo.classList.toggle("hidden", false);
  });

  document.addEventListener("click", function (event) {
    if (
      !searchBar.contains(event.target) &&
      !searchBarInfo.contains(event.target)
    ) {
      searchBarInfo.classList.add("hidden");
    }
  });
}
