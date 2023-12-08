let currentPage = 1;
let isFetching = false;

const filterButton = document.querySelector(".filters-button");

if (filterButton) {
  filterButton.addEventListener("click", function (event) {
    event.preventDefault();
    const questionsFilters = document.querySelector(".questions-filters");
    if (questionsFilters) {
      questionsFilters.toggleAttribute("hidden");
    }
  });

  window.addEventListener("scroll", () => {
    if (
      window.innerHeight + window.scrollY >= document.body.offsetHeight - 10 &&
      !isFetching
    ) {
      loadMoreQuestions();
    }
  });
}

const applyButton = document.querySelector("#apply-button");

if (applyButton) {
  applyButton.addEventListener("click", async function (event) {
    event.preventDefault();

    let communities = Array();
    const usernameButton = document.querySelector(".my-account-button");
    if (usernameButton) {
      let username = usernameButton.textContent.split('(')[1];
      username = username.slice(0, -1);
      const user = await fetchUser(username);
      user[0]['communities'].forEach((community) => communities.push(community['id']));
    }
  
    isFetching = true;
    const after = document.querySelector("#after").value || "2020-01-01";
    const before = document.querySelector("#before").value || "2030-12-31";
    let community = window.location.pathname.split('/').pop();
    if (community === 'questions') {
      community = 0;
      communities = 0;
    } else if (community === 'feed') {
      community = 0;
    }
    
    const text = document.querySelector(".live-search").value;
    const sort = document.querySelector('input[name="sort"]:checked').value;

    currentPage = 1;
    const questions = await fetchQuestions(
      after,
      before,
      community,
      communities,
      text,
      sort,
      currentPage
    );

    const questionsCountElement = document.querySelector(".questions-number");

    if (questionsCountElement) {
      questionsCountElement.textContent = `${questions.total} questions`;
    }

    const section = document.querySelector("#questions");
    section.innerHTML = "";

    questions.data.forEach((question) => {
      const newQuestion = addQuestion(question);
      section.append(newQuestion);
    });

    isFetching = false;
  });
}

async function loadMoreQuestions() {
  let communities = Array();
  const usernameButton = document.querySelector(".my-account-button");
  if (usernameButton) {
    let username = usernameButton.textContent.split('(')[1];
    username = username.slice(0, -1);
    const user = await fetchUser(username);
    user[0]['communities'].forEach((community) => communities.push(community['id']));
  }

  isFetching = true;
  const after = document.querySelector("#after").value || "2020-01-01";
  const before = document.querySelector("#before").value || "2030-12-31";
  let community = window.location.pathname.split('/').pop();
  if (community === 'questions') {
    community = 0;
    communities = 0;
  } else if (community === 'feed') {
    community = 0;
  }

  const text = document.querySelector(".live-search").value;
  const sort = document.querySelector('input[name="sort"]:checked').value;

  currentPage++;
  const newQuestions = await fetchQuestions(
    after,
    before,
    community,
    communities,
    text,
    sort,
    currentPage
  );

  const section = document.querySelector("#questions");
  newQuestions.data.forEach((question) => {
    const newQuestion = addQuestion(question);
    section.append(newQuestion);
  });

  isFetching = false;
}

async function fetchQuestions(after, before, community, communities, text, sort, page) {
  const url =
    "/api/questions?" +
    encodeForAjax({
      after: after,
      before: before,
      community: community,
      communities: communities,
      text: text,
      sort: sort,
      page: page,
    });

  const response = await fetch(url);
  return await response.json();
}

function addQuestion(question) {
  let expert = "";
  console.log(question.user)
  question.user.communities_rating.forEach ((rating) => {
    if (rating.pivot.id_community === question.community.id && rating.pivot.expert) {
      expert = `<img class="experts-stars" src="../assets/rating-images/star-expert.png" alt="Expert stars">`
    }
  });

  const newQuestion = document.createElement("div");
  newQuestion.classList.add("question-container");
  newQuestion.innerHTML = `
  <img class="member-pfp question-member-pfp" src="../${question.user.image}" alt="User's profile picture" />
  <div class="content-right">
    <div class="question-details">
      <a href="../users/${question.user.id}" class="question-username">${question.user.username}</a>
      ${expert}
      <span class="question-asked-date">Asked: ${question.date}</span>
      <span class="question-community">In: ${question.community.name}</span>
    </div>
    <h2 class="question-title"><a href="../questions/${question.id}">${question.title}</a></h2>
    <p class="question-description">${question.content}</p>
    <div class="answers-details">
      <button class="question-answer-btn">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
             xmlns="http://www.w3.org/2000/svg">
          <path
              d="M22.8 4.8H20.4V15.6H4.8V18C4.8 18.66 5.34 19.2 6 19.2H19.2L24 24V6C24 5.34 23.46 4.8 22.8 4.8ZM18 12V1.2C18 0.54 17.46 0 16.8 0H1.2C0.54 0 0 0.54 0 1.2V18L4.8 13.2H16.8C17.46 13.2 18 12.66 18 12Z"
              fill="#abacb1" />
        </svg>${question.answers_count} Answers</button>
      <span class="question-upvotes">
              <svg width="18" height="12" viewBox="0 0 18 12" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z" fill="#38B6FF" />
              </svg>
        ${question.likes_count}</span>
      <span class="question-downvotes">
              <svg width="18" height="12" viewBox="0 0 18 12" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z" fill="#ABACB1" />
              </svg>
        ${question.dislikes_count}</span>
    </div>
  </div>
  `;

  return newQuestion;
}

async function fetchUser(username) {
  const url =
    "/api/users?" +
    encodeForAjax({
      username: username,
    });

  const response = await fetch(url);
  return await response.json();
}
