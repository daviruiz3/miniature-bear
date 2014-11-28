select likes, dislikes, fortune_twitter_id, oauthtoken, oauthsecret from fortuneList
join student on student.id = fortuneList.student_id
where status = 1 && username = 'vincet509'
Order by student_id