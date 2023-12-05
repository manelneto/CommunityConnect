async function followTag(id) {
  console.log("following tag", id);
  await fetch('/api/tags/follow', {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: encodeForAjax({ id: id }),
  });
}

async function unfollowTag(id) {
  console.log("unfollowing tag", id);
  await fetch(`/api/tags/unfollow`, {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: encodeForAjax({ id: id }),
  });
}

const followTagButtons = document.querySelectorAll(".tag-tooltip-content button");

if (followTagButtons) {
  followTagButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      const id = button.id;
      if (button.classList.contains("follow-tag-button")) {
        followTag(id);
        let span = button.querySelector("span");
        if (span) {
          span.textContent = 'Unfollow tag';
        }
      } else { 
        unfollowTag(id);
        let span = button.querySelector("span");
        if (span) {
          span.textContent = 'Follow tag';
        }
      }
      button.classList.toggle("follow-tag-button");
      button.classList.toggle("unfollow-tag-button");
    });
  });
}
