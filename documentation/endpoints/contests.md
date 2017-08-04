# Contests Endpoint

- [Retrieve All Contests] (#retrieve-all-contests)

## Retrieve All Contests

```
GET /api/v2/contests
```

**Headers**

```javascript
Accept: application/json
Content-Type: application/json
```

**Optional Query Parameters**
- **id** _(integer)_
  - The contest id(s) to filter the response by.
  - e.g. `/contests?filter[id]=37`
- **limit** _(default is 20)_
  - Set the number of records to return in a single response.
  - e.g. `/contests?limit=35`
- **page** _(integer)_
  - For pagination, specify page of activity to return in the response.
  - e.g. `/contests?page=2`
- **campaign_id** _(integer)_
  - The campaign id(s) to filter the response by.
  - e.g. `/contests?filter[campaign_id]=1631,1617`
- **campaign_run_id** _(integer)_
  - The campaign run id(s) to filter the response by.
  - e.g. `/contests?filter[campaign_run_id]=1903,1236`
- **updated_at** _(timestamp)_
  - Return records that have been updated at after the updated_at param value. 
  - e.g. `/contests?filter[updated_at]=2017-05-25 20:14:48`

**Example Request**

```sh
curl -X POST \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  http://gladiator.dosomething.org/api/v2/contests
```

**Example Response**

```javascript
// 200 Okay

{
    "data": [
        {
            "id": 37,
            "campaign_id": 1631,
            "campaign_run_id": 1903,
            "sender": {
                "name": "Test Shae",
                "email": "ssmith@dosomething.org"
            },
            "created_at": "2016-07-28T17:25:56+00:00",
            "updated_at": "2016-09-28T16:49:25+00:00",
            "waitingRoom": {
                "data": {
                    "id": 37,
                    "open": true,
                    "signup_dates": {
                        "start": "2016-07-28T00:00:00+00:00",
                        "end": "2017-12-31T00:00:00+00:00"
                    },
                    "users": [
                        "596e2e1d7f43c233c948170b",
                        "596e68267f43c234225b7ba6"
                    ],
                    "created_at": "2016-07-28T17:25:56+00:00",
                    "updated_at": "2016-07-28T17:25:56+00:00"
                }
            },
            "competitions": {
                "data": [
                    {
                        "id": 14,
                        "competition_dates": {
                            "start_date": "2016-08-03T00:00:00+00:00",
                            "end_date": "2016-09-30T23:59:59+00:00"
                        },
                        "leaderboard_msg_day": "Monday",
                        "rules": "http://www.therules.com",
                        "users": [],
                        "subscribed_users": [],
                        "unsubscribed_users": [],
                        "created_at": "2016-08-03T13:56:39+00:00",
                        "updated_at": "2016-08-03T13:56:39+00:00"
                    },
                    {
                        "id": 15,
                        "competition_dates": {
                            "start_date": "2017-01-19T00:00:00+00:00",
                            "end_date": "2017-02-28T23:59:59+00:00"
                        },
                        "leaderboard_msg_day": "Monday",
                        "rules": "http://www.fake.com",
                        "users": [
                            "559442cca59dbfc9578b4bf4"
                        ],
                        "subscribed_users": [
                            "559442cca59dbfc9578b4bf4"
                        ],
                        "unsubscribed_users": [],
                        "created_at": "2017-01-19T20:20:14+00:00",
                        "updated_at": "2017-01-19T20:20:14+00:00"
                    },
                    {
                        "id": 20,
                        "competition_dates": {
                            "start_date": "2017-03-28T00:00:00+00:00",
                            "end_date": "2017-12-04T23:59:59+00:00"
                        },
                        "leaderboard_msg_day": "Monday",
                        "rules": "https://qa-gladiator.dosomething.org/waitingrooms/37/split",
                        "users": [
                            "559442cca59dbfc9578b4bf4"
                        ],
                        "subscribed_users": [
                            "559442cca59dbfc9578b4bf4"
                        ],
                        "unsubscribed_users": [],
                        "created_at": "2017-03-28T18:27:28+00:00",
                        "updated_at": "2017-03-28T18:27:28+00:00"
                    },
                    {
                        "id": 21,
                        "competition_dates": {
                            "start_date": "2016-08-03T00:00:00+00:00",
                            "end_date": "2016-09-30T23:59:59+00:00"
                        },
                        "leaderboard_msg_day": "Monday",
                        "rules": "http://www.therules.com",
                        "users": [
                            "575eefeea59dbf87738b4569",
                            "574ef3b0a59dbfa5768b456a",
                            "57e98245a59dbf2e138b461d",
                            "559442cca59dbfc9578b4bf4"
                        ],
                        "subscribed_users": [
                            "575eefeea59dbf87738b4569",
                            "574ef3b0a59dbfa5768b456a",
                            "57e98245a59dbf2e138b461d",
                            "559442cca59dbfc9578b4bf4"
                        ],
                        "unsubscribed_users": [],
                        "created_at": "2016-08-03T13:56:39+00:00",
                        "updated_at": "2016-08-03T13:56:39+00:00"
                    }
                ],
                "meta": {
                    "total": 4
                }
            },
            "messages": {
                "data": [
                    {
                        "id": 316,
                        "contest_id": 37,
                        "type": {
                            "name": "welcome",
                            "key": 1
                        },
                        "label": "Welcome",
                        "subject": "Welcome, :first_name:!",
                        "body": "Woohoo, so glad you signed up for my :campaign_title: competition, :first_name:! Feel free to get a head start on the competition! Again, winners will be selected based on the greatest number of :reportback_noun: :reportback_verb:.\r\n\r\nI’ll be in touch with more info in the next few days. Excited to watch you climb the leaderboard and crush the competition!\r\n\r\n:sender_name:",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-07-28T17:25:56+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 317,
                        "contest_id": 37,
                        "type": {
                            "name": "info",
                            "key": 1
                        },
                        "label": "Competition info",
                        "subject": ":first_name:! Here’s more :campaign_title: competition info",
                        "body": "Just wanted to send along some more info about the :campaign_title: competition you signed up for! The rules are simple:\r\n\r\n1. The more :reportback_noun: :reportback_verb:, the higher you move up the leaderboard.\r\n\r\n2. To be considered, go to the [Prove It](:prove_it_link:) section of the campaign and upload a photo that clearly shows you and all :reportback_noun: :reportback_verb:. Submissions are due each :leaderboard_msg_day-1: night throughout the campaign.\r\n\r\nThe competitor with the most :reportback_noun: :reportback_verb: by the competition deadline of :end_date:, wins $100 on an Amex gift card. 2nd - $50, 3rd - $25.\r\n\r\nYour first update is due on :leaderboard_msg_day-1: before 10 PM EST. If you have an update for me and want to see yourself on :leaderboard_msg_day:’s leaderboard, simply:\r\n\r\n   - Go to the [Prove It](:prove_it_link:) section\r\n\r\n   - Upload your photo \r\n\r\n   - Click “submit your pic”\r\n\r\nOn :leaderboard_msg_day:, I will send you the updated standings so you can see yourself on the leaderboard.\r\n\r\nRootin’ for ya, :first_name:,\r\n\r\n:sender_name:\r\n\r\n:rules_url:",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-07-28T17:25:56+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 318,
                        "contest_id": 37,
                        "type": {
                            "name": "checkin",
                            "key": 1
                        },
                        "label": "Where are you? Check status",
                        "subject": "Is everything ok, :first_name:?",
                        "body": "I noticed you haven’t upload a picture of your :reportback_noun: :reportback_verb: to :campaign_title: yet. Just wanted to see if everything is ok!\r\n\r\nIf you are able, you still have until :leaderboard_msg_day-1: to be included in the next update! Take a picture and upload your photo [here](:prove_it_link:).\r\n\r\nLet me know if I can help you, :first_name:.\r\n\r\n![something](https://media.giphy.com/media/26FPwvR2qSUGjEvbG/giphy.gif)\r\n\r\n:sender_name:",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-12-20T19:46:24+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 319,
                        "contest_id": 37,
                        "type": {
                            "name": "reminder",
                            "key": 1
                        },
                        "label": "Reminder for first submission due",
                        "subject": "Do you have any more :reportback_noun:?",
                        "body": "Hey, :first_name:!\r\n\r\nJust a reminder that your next update is due :leaderboard_msg_day-1: before 10:00 PM EST. If you want to see yourself on the leaderboard, [upload a photo](:prove_it_link:) showing you and all :reportback_noun: :reportback_verb:.\r\n\r\nOn :leaderboard_msg_day:, I will send you the updated standings.\r\n\r\nLet me know if I can help, :first_name:!\r\n\r\n:sender_name:",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-07-28T17:25:56+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 320,
                        "contest_id": 37,
                        "type": {
                            "name": "reminder",
                            "key": 2
                        },
                        "label": "Reminder for submission photo due",
                        "subject": "Don’t forget to send us your :campaign_title: competition photo!",
                        "body": ":first_name:\r\n\r\nYour next update is due tonight before 10pm est, so if you want to make the leaderboard and see your name featured, [upload your photo](:prove_it_link:) with all your :reportback_noun: :reportback_verb:.\r\n\r\nCan’t wait to see it!\r\n\r\n:sender_name:",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-07-28T17:25:56+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 321,
                        "contest_id": 37,
                        "type": {
                            "name": "reminder",
                            "key": 3
                        },
                        "label": "Almost over reminder",
                        "subject": "This :campaign_title: competition is almost over, :first_name:!",
                        "body": "Last call: The final deadline for this competition is this :leaderboard_msg_day-1: night before 10:00 PM EST!\r\n\r\nWhen you’re ready, [upload your final photo](:prove_it_link:) showing all your :reportback_noun: :reportback_verb:. If you’re updating your submission with a new photo, simply click “add another photo” and write in how many :reportback_noun: you :reportback_verb:.\r\n\r\nLooking forward to seeing your final pic, :first_name:!\r\n\r\n:sender_name:",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-07-28T17:25:56+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 322,
                        "contest_id": 37,
                        "type": {
                            "name": "reminder",
                            "key": 4
                        },
                        "label": "Last minute reminder",
                        "subject": "LAST CHANCE! The :campaign_title: competition Deadline is now!",
                        "body": ":first_name:,\r\n\r\nThe :campaign_title: Competition closes at 10:00 PM EST TONIGHT. Take this moment to [upload your final photo](:prove_it_link:) clearly showing you and all :reportback_noun: :reportback_verb:.\r\n\r\nI will send the final results tomorrow, so keep your fingers crossed. Thanks for doing an awesome job to make an impact!\r\n\r\n:sender_name:",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-07-28T17:25:56+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 323,
                        "contest_id": 37,
                        "type": {
                            "name": "leaderboard",
                            "key": 1
                        },
                        "label": "Leaderboard update",
                        "subject": "1st :campaign_title: Leaderboard Update",
                        "body": "Hello Competitors,\r\n\r\nHere is your first official :campaign_title: competition update! The competition ends on :end_date:. Finish in the top 3 in :reportback_noun: :reportback_verb: and win:\r\n\r\n- 1st place: ­ $100 amex card\r\n- 2nd place: ­ $50 amex card\r\n- 3rd place: ­ $25 amex card\r\n\r\nTwo more weeks to increase your number of :reportback_noun: :reportback_verb: to move up the leaderboard! [Upload your photos here](:prove_it_link:).\r\n\r\n:pro_tip:\r\n\r\nNext :reportback_noun: photo update will be due :leaderboard_msg_day-1: before 10pm est.\r\n\r\nHere is the leaderboard! Shoutouts to the top 3 below:",
                        "signoff": "",
                        "pro_tip": null,
                        "show_images": 0,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-12-20T19:46:24+00:00",
                        "featuredReportbacks": {
                            "data": [
                                {
                                    "id": 3,
                                    "competition_id": 21,
                                    "message_id": 323,
                                    "reportback": {
                                        "id": 1234,
                                        "item_id": 5678
                                    },
                                    "shoutout": "shout out",
                                    "created_at": "2017-08-04T14:28:26+00:00",
                                    "updated_at": "2017-08-04T14:28:26+00:00"
                                },
                                {
                                    "id": 6,
                                    "competition_id": 20,
                                    "message_id": 323,
                                    "reportback": {
                                        "id": 453,
                                        "item_id": 1234
                                    },
                                    "shoutout": "shoutout",
                                    "created_at": "2017-08-04T14:30:02+00:00",
                                    "updated_at": "2017-08-04T14:30:02+00:00"
                                }
                            ]
                        },
                        "leaderboardPhotos": {
                            "data": [
                                {
                                    "id": 7,
                                    "competition_id": 21,
                                    "message_id": 323,
                                    "northstar_id": "559442cca59dbfc9578b4bf4",
                                    "reportback": {
                                        "id": 5789,
                                        "item_id": 753
                                    },
                                    "created_at": "2017-08-04T14:43:41+00:00",
                                    "updated_at": "2017-08-04T14:43:41+00:00"
                                },
                                {
                                    "id": 8,
                                    "competition_id": 20,
                                    "message_id": 323,
                                    "northstar_id": "559442cca59dbfc9578b4bf4",
                                    "reportback": {
                                        "id": 5789,
                                        "item_id": 654
                                    },
                                    "created_at": "2017-08-04T14:44:16+00:00",
                                    "updated_at": "2017-08-04T14:44:16+00:00"
                                }
                            ]
                        }
                    },
                    {
                        "id": 324,
                        "contest_id": 37,
                        "type": {
                            "name": "leaderboard",
                            "key": 2
                        },
                        "label": "Leaderboard update 2",
                        "subject": "Leaderboard update #2 for the :campaign_title: competition!",
                        "body": "Hello, competitors-- \r\n\r\n1 more week! This :campaign_title: competition ends on :end_date:, so it’s time to make your mark.\r\n\r\n:pro_tip:\r\n\r\nA final photo with your :reportback_noun: photo update will be due :leaderboard_msg_day-1: before 10pm EST. [Upload yours here](:prove_it_link:).\r\n\r\nHere is the leaderboard! Shoutouts to the top 3 below:\r\n\r\n1 more week to make your mark and climb up the leaderboard!",
                        "signoff": "1 more week to make your mark and climb up the leaderboard!",
                        "pro_tip": null,
                        "show_images": 0,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-12-20T19:46:24+00:00",
                        "featuredReportbacks": {
                            "data": [
                                {
                                    "id": 4,
                                    "competition_id": 21,
                                    "message_id": 324,
                                    "reportback": {
                                        "id": 8493,
                                        "item_id": 291
                                    },
                                    "shoutout": "shoutout",
                                    "created_at": "2017-08-04T14:28:39+00:00",
                                    "updated_at": "2017-08-04T14:28:39+00:00"
                                },
                                {
                                    "id": 7,
                                    "competition_id": 20,
                                    "message_id": 324,
                                    "reportback": {
                                        "id": 3939,
                                        "item_id": 2030
                                    },
                                    "shoutout": "shoutout",
                                    "created_at": "2017-08-04T14:30:20+00:00",
                                    "updated_at": "2017-08-04T14:30:20+00:00"
                                }
                            ]
                        },
                        "leaderboardPhotos": {
                            "data": [
                                {
                                    "id": 6,
                                    "competition_id": 21,
                                    "message_id": 324,
                                    "northstar_id": "559442cca59dbfc9578b4bf4",
                                    "reportback": {
                                        "id": 5789,
                                        "item_id": 567
                                    },
                                    "created_at": "2017-08-04T14:43:29+00:00",
                                    "updated_at": "2017-08-04T14:43:29+00:00"
                                },
                                {
                                    "id": 9,
                                    "competition_id": 20,
                                    "message_id": 324,
                                    "northstar_id": "559442cca59dbfc9578b4bf4",
                                    "reportback": {
                                        "id": 5789,
                                        "item_id": 2342
                                    },
                                    "created_at": "2017-08-04T14:44:24+00:00",
                                    "updated_at": "2017-08-04T14:44:24+00:00"
                                }
                            ]
                        }
                    },
                    {
                        "id": 325,
                        "contest_id": 37,
                        "type": {
                            "name": "leaderboard",
                            "key": 3
                        },
                        "label": "Final leaderboard update",
                        "subject": "Here are the :campaign_title: competition winners!",
                        "body": "This is it, the final leaderboard and results. Thank you for spending these last 3 weeks, working hard not only to climb the leaderboard, but also to affect lives around you and make the world a better place.\r\n\r\nHere is your final leaderboard. Pics, prizes and honorable mentions below:\r\n\r\n",
                        "signoff": "",
                        "pro_tip": null,
                        "show_images": 0,
                        "created_at": "2016-07-28T17:25:56+00:00",
                        "updated_at": "2016-12-20T19:46:24+00:00",
                        "featuredReportbacks": {
                            "data": [
                                {
                                    "id": 5,
                                    "competition_id": 21,
                                    "message_id": 325,
                                    "reportback": {
                                        "id": 9391,
                                        "item_id": 3984
                                    },
                                    "shoutout": "shoutout",
                                    "created_at": "2017-08-04T14:28:52+00:00",
                                    "updated_at": "2017-08-04T14:28:52+00:00"
                                },
                                {
                                    "id": 8,
                                    "competition_id": 20,
                                    "message_id": 325,
                                    "reportback": {
                                        "id": 8489,
                                        "item_id": 2838
                                    },
                                    "shoutout": "shoutout",
                                    "created_at": "2017-08-04T14:30:31+00:00",
                                    "updated_at": "2017-08-04T14:30:31+00:00"
                                }
                            ]
                        },
                        "leaderboardPhotos": {
                            "data": [
                                {
                                    "id": 5,
                                    "competition_id": 21,
                                    "message_id": 325,
                                    "northstar_id": "559442cca59dbfc9578b4bf4",
                                    "reportback": {
                                        "id": 5789,
                                        "item_id": 21
                                    },
                                    "created_at": "2017-08-04T14:40:55+00:00",
                                    "updated_at": "2017-08-04T14:40:55+00:00"
                                },
                                {
                                    "id": 10,
                                    "competition_id": 20,
                                    "message_id": 325,
                                    "northstar_id": "559442cca59dbfc9578b4bf4",
                                    "reportback": {
                                        "id": 5789,
                                        "item_id": 5656
                                    },
                                    "created_at": "2017-08-04T14:44:30+00:00",
                                    "updated_at": "2017-08-04T14:44:30+00:00"
                                }
                            ]
                        }
                    }
                ]
            }
        },
        {
            "id": 3,
            "campaign_id": 1617,
            "campaign_run_id": 1833,
            "sender": {
                "name": null,
                "email": null
            },
            "created_at": "2016-03-08T16:32:27+00:00",
            "updated_at": "2016-04-07T15:57:08+00:00",
            "waitingRoom": {
                "data": {
                    "id": 3,
                    "open": false,
                    "signup_dates": {
                        "start": "2016-03-08T00:00:00+00:00",
                        "end": "2016-03-15T00:00:00+00:00"
                    },
                    "users": [
                        "55944275a59dbfca578b46fc",
                        "55944278a59dbfc9578b472f",
                        "559442cfa59dbfc9578b4c14",
                        "...",
                    ],
                    "created_at": "2016-03-08T16:32:27+00:00",
                    "updated_at": "2016-03-22T18:02:23+00:00"
                }
            },
            "competitions": {
                "data": [],
                "meta": {
                    "total": 0
                }
            },
            "messages": {
                "data": [
                    {
                        "id": 10,
                        "contest_id": 3,
                        "type": {
                            "name": "checkin",
                            "key": 0
                        },
                        "label": "Where are you? Check status",
                        "subject": "Is everything ok, [First Name]?",
                        "body": "I noticed you didn’t send in a picture of your [reportback item] into the DoSomething site last update. Just wanted to see if everything is ok! Even if you can't hit your goal, just a few [reportback items] can make a huge difference! \n\rIf you are able, you still have until Sunday night for the next update! Take a picture and upload to our site right here [link to campaign]. \n\rNeed a little inspiration? Check out the photo below as a great example! Let me know if there’s any way I can help you, $%First Name%!",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-04-01T20:56:32+00:00",
                        "updated_at": "2016-04-01T20:56:32+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 11,
                        "contest_id": 3,
                        "type": {
                            "name": "leaderboard",
                            "key": 0
                        },
                        "label": "Leaderboard update",
                        "subject": "1st Leaderboard Update",
                        "body": "Hello Competitors, \n\rHere is your 1st official [Campaign Name] competition update! The competition ends on [Competition End Date]. Finish in the top 3 in [Report Back Noun] [Report Back Verb] and win: \n\r- 1st place ­ $100 amex card\r- 2nd place ­ $50 amex card \r- 3rd place ­ $25 amex card \n\rKeep collecting [Report Back Noun] for the next 2 weeks to move up the leaderboard! \n\rPro tip ­ [Contest Pro Tip] \n\rNext update selfie with your [Report Back Noun] will be due [Leaderboard Day ­ 1] before 10pm est. \n\rHere is the leaderboard! Top 3 and a shoutouts below: \n\r[Leaderboard] \n\r[1 Random Image w/ comment] \n\r[Top 3 competitor IMAGES w/comment] \n\r[#] more weeks to make your mark and climb up the leaderboard!",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-04-01T20:56:32+00:00",
                        "updated_at": "2016-04-01T20:56:32+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 12,
                        "contest_id": 3,
                        "type": {
                            "name": "leaderboard",
                            "key": 1
                        },
                        "label": "Final leaderboard update",
                        "subject": "The Results Are In!",
                        "body": "This is it. The final leaderboard. Thank you for spending these last 3 weeks, battling not only to climb the leaderboard, but affecting so many lives around you in a truly impactful way. \n\rHere is your final leaderboard. Pics, prizes and honorable mentions below:",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-04-01T20:56:32+00:00",
                        "updated_at": "2016-04-01T20:56:32+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 13,
                        "contest_id": 3,
                        "type": {
                            "name": "reminder",
                            "key": 0
                        },
                        "label": "Reminder for first submission due",
                        "subject": "Hey [First Name]!",
                        "body": "Just wanted to send along some more info about the [Campaign Name] Competition you signed up for. The rules are simple: \n\r1. The more [Report Back Noun] [Report Back Verb], the higher you move up the leaderboard \n\r2. You must prove it by uploading a selfie, clearly showing you and all [Report Back Noun] [Report Back Verb] each Sunday night \n\r3. The competitor with the most [Report Back Noun] [Report Back Verb] by the competition deadline of [Competition End Date], wins $100 on an amex gift card. 2nd ­ $50, 3rd ­ $25 \n\rYour first update is due on [Leaderboard Day ­1] before 10pm est. If you have an update for me, and want to see yourself on [Leaderboard Day]’s leaderboard, simply click the blue icon below!",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-04-01T20:56:32+00:00",
                        "updated_at": "2016-04-01T20:56:32+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 14,
                        "contest_id": 3,
                        "type": {
                            "name": "reminder",
                            "key": 1
                        },
                        "label": "Reminder to submit v1",
                        "subject": "Do you have anymore [Report Back Noun]?",
                        "body": "[First Name] ­\n\rYour next update is due [Leaderboard Day ­1] before 10pm est. If you want to see yourself on the leaderboard, simply click on the icon below, then upload a selfie clearly showing you and all [Report Back Noun] [Report Back Verb] On Monday, I will send you the updated standings. \n\rLet me know if I can help, [First Name]! \n\r[Name of Staff]",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-04-01T20:56:32+00:00",
                        "updated_at": "2016-04-01T20:56:32+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 15,
                        "contest_id": 3,
                        "type": {
                            "name": "reminder",
                            "key": 2
                        },
                        "label": "Reminder to submit v2",
                        "subject": "This Competition is Almost Over, [First Name]",
                        "body": "The final deadline for this competition is this Sunday night before 10pm EST! \n\rReady to upload a selfie now showing all your [Report Back Noun] [Report Back Verb]? Click the icon below. \n\rLooking forward to seeing your final pic, [First Name]!",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-04-01T20:56:32+00:00",
                        "updated_at": "2016-04-01T20:56:32+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 16,
                        "contest_id": 3,
                        "type": {
                            "name": "reminder",
                            "key": 3
                        },
                        "label": "Last minute reminder v1",
                        "subject": "Send us your [Campaign Name] Competition Photo!",
                        "body": "[First Name]! \n\rThis is your friendly reminder that your next update is due tonight at 10pm est, so if you want to make the leaderboard and see your name featured, upload your selfie with all your [Report Back Noun] [Report Back Verb]. \n\rCan’t wait to see it! \n\r[Name of Staff]",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-04-01T20:56:32+00:00",
                        "updated_at": "2016-04-01T20:56:32+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 17,
                        "contest_id": 3,
                        "type": {
                            "name": "reminder",
                            "key": 4
                        },
                        "label": "Last minute reminder v2",
                        "subject": "The Competition Deadline is Now!",
                        "body": "You have until tonight at 10pm EST to upload your final, badass selfie with all of your [Report Back Noun]. \n\rUpload your final selfie with your [Report Back Noun] below. Can’t wait to see how you did, [First Name]!",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-04-01T20:56:32+00:00",
                        "updated_at": "2016-04-01T20:56:32+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    },
                    {
                        "id": 18,
                        "contest_id": 3,
                        "type": {
                            "name": "welcome",
                            "key": 0
                        },
                        "label": "Welcome",
                        "subject": "Welcome, [First Name]!",
                        "body": "Woohoo, so glad you signed up for my [Campaign Name] competition, [First Name]! Feel free to get a head start on the competition and begin today. \n\rI will be in touch with you with more info in the next few days. Excited to watch you climb the leaderboard and crush the competition! \n\r[Name of Staff]",
                        "signoff": null,
                        "pro_tip": null,
                        "show_images": null,
                        "created_at": "2016-04-01T20:56:32+00:00",
                        "updated_at": "2016-04-01T20:56:32+00:00",
                        "featuredReportbacks": {
                            "data": []
                        },
                        "leaderboardPhotos": {
                            "data": []
                        }
                    }
                ]
            }
        }
    ],
    "meta": {
        "pagination": {
            "total": 42,
            "count": 2,
            "per_page": 2,
            "current_page": 1,
            "total_pages": 21,
            "links": {
                "next": "http://gladiator.app/api/v2/contests?limit=2&page=2"
            }
        }
    }
}
```
