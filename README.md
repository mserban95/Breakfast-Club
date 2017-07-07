Breakfast-Club
===============

The purpose of the task is to create a project in Symfony that allows Slack users to write a command in every channel, that only they can see, that allows them to join week by week the breakfast club here in Palma and another command for unsubscribe from the breakfast-club.
This is how it has to work:

For subscribe:
1. The user writes a command in Slack: “/join-breakfastclub”
2. If the user types it between Mo-Fri until 16:00h, he get’s subscribed for the following week
3. Then the username and the dates of the following week get stored in a database.
4. Once they are successfully stored, the user receives a reply in Slack: “You have successfully joined the Breakfast Club between {dates}. Please go to Carlos’ desk to pay the corresponding 5€!”
5. If the user has already subscribed and he is inactive but he types command for subscribe -> The user receives via Slack a reply: "Your subscription is active again between {dates}.
6. If the user has already subscribed and he is active but he types the command for subscribe -> The user receives via Slack a reply: “You have already subscribed between {dates}. You are welcome to join again from next week”. 

For unsubscribe:
1. The user writes a command in Slack: "/unsubscribe-breakfastclub"
2. If the user is subscribed, this will become inactive and will receive a reply in Slack: "Your subscription between {dates} is inactive now." If he is not subscribed yet, the user will receive a reply in Slack: "You are not yet subscribed at Breakfast Club. Run /join-breakfastclub to subscribe."
3. If the user had already subscribed and he is inactive but he types the command for unsubscribe -> The user receives via Slack a reply: "You have already unsubscribed from Breakfast Club."

Edge cases:
1. If the user types the command after Friday 16:00-> The user get’s subscribed for 2 weeks later.
2. In every Monday, all users enrolled in the breakfast club in that week will be removed from the database.
