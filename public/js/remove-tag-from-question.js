async function removeTagFromQuestion(questionId, tagId) {
  console.log('Removing tag');
  await fetch(`/api/questions/edit/remove-tag/${questionId}/${tagId}`, {
      method: "POST",
      headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          "Content-Type": "application/x-www-form-urlencoded",
      },
      body: encodeForAjax({ questionId: questionId, tagId: tagId }),
  });
}

const tags = document.querySelectorAll(".edit-question-tags li");

if (tags) {
  tags.forEach((tag) => {
    tag.addEventListener("click", (event) => {
      event.preventDefault();
      
      const tagId = tag.id;
      const [id_tag, id_question] = tagId.split('-');

      removeTagFromQuestion(id_question, id_tag);

      tag.classList.add("hidden");
    });
  })
}
