# 通知服务设计
## 需求背景
（1）快递已签收等情景下，后台用户无法及时收到消息并反馈；    
（2）当部分管理员执行了某些重要的影响大的操作（例如删除了门店），其他管理员难以发现；    
## 需求目标
（1）一个通知系统，可以给固定的后台用户组发送消息，接收方右上角显示通知数量；    
（2）消息分类，例如快递消息10条，危险操作消息10条；    
（3）可以区分已读和未读消息，并定时清空过期消息（可设置过期时间）    
（4）消息可撤回       
（5）考虑是否需要给单个用户发送消息？
## 需求实现
（1）发送消息给用户组，用户在登录状态时定时查询消息表，当有未读消息时显示；    
（2）读取消息时按照消息分类读取；        
（3）每个用户存储已读消息记录，点击消息算做已读；无论是否已读，消息在发送后固定时间（例如10天后）直接删除     
（4）选择撤回消息，则修改消息表消息状态；由于用户不存储消息本身，因此可以直接撤回      
（5）如果需要给单个用户发送消息，需要存储消息发送类型，是给单人还是分组；    
注意：消息从发送方发出后10天变成过期，20天彻底删除记录     
## 时序图
发送方：消息发送者，所有需要发送消息的程序；    
接收方：需要接收消息的分组，例如管理员，门店管理员；    

---
<uml>
@startuml
actor "发送方" as sender
participant "通知服务" as notice
participant "接收方" as receiver
sender -> notice: 发送消息
notice -> notice: 检查消息格式
notice -> notice: 存储消息内容
notice -> sender: 回调通知已发送
receiver -> notice: 拉取消息列表
receiver -> notice: 改变消息状态
notice -> notice: 定时清理过期消息
@enduml
</uml>
---

## 表结构
1 消息表notice_message

| 字段  | 含义 | 类型 | 示例 |
|:-----:|------|------|:------:|
| _id | mongodb id | ObjectId |  |
| content | 消息内容 | string | 某某影楼已签收，请及时对接 |
| create_time | 创建时间 | int |  |
| update_time | 更新时间 | int |  |
| type | 消息类型0：分组1：单人 | int |  |
| user_id | 发送用户 | string |  |
| receive_id | 接收方（可能为分组和单人） | string |  |
| message_group | 消息所属分组 | string |  |
| has_read | 已读用户 | string | 已读用户列表 |
| status | 消息状态0：正常1：过期2：撤回3：删除 | string | 143242524 |

2 消息组表（暂不确定是否需要分组，作为可扩展功能）

| 字段  | 含义 | 类型 | 示例 |
|:-----:|------|------|:------:|
| _id | mongodb id | ObjectId |  |
| name | 分组名称 | string | 物流信息 |
| create_time | 创建时间 | int |  |
| update_time | 更新时间 | int |  |
## 流程图

---
<uml>
@startuml
start
:发送消息;
if (是否发送成功) then (是)
    : 存储消息;
else (否)
    : 发送消息;
endif
    : 用户读取消息记录;
if (是否在消息组中) then (是)
    : 展示消息记录;
endif
: 更改消息状态;
@enduml
</uml>
---

## 接口
1 发送消息

* 请求方式 POST

* 描述：发送消息

* 接口：backend/Notice/sendMsg

* 请求参数：

| 字段  | 类型 | 是否必填 | 注释 |
|:-----:|------|------|:------:|
| user | string | 是 | 发送方 |
| receiver | string | 是 | 接收方 |
| type | int | 否，默认值0 | 类型：0：用户组，1：用户 |
| content | string | 是 | 消息内容 |

* 请求结果：

```
{
    "logid": "5ce4ef00699759f52653428d",
    "data": true,
    "status": 200,
    "message": "",
    "st": 1558507267.5984659,
    "crt": 3.7542481422424316
}
```
2 读取消息

* 请求方式 POST

* 描述：读取消息    

* 接口： backend/Notice/readMsg

* 请求参数：    
 
| 字段  | 类型 | 是否必填 | 注释 |
|:-----:|------|------|:------:|
| user | string | 是 | 当前用户 |

* 请求结果

```
{
    "logid": "5ce4ef00699759f52653428d",
    "data": {
        "dataList": [
            {
                "_id":"25cf8d44fde98bd003b3cdc2d0",
                "content":"门店：bilibili商品已发货，请注意",
                "create_time":1560309983,
                "type":"0",
                "user_id":"5cf8d358de98bd004266321a",
                "receive_id":"5cf8d44fde98bd003b3cdc2d",
                "status":"0"
            },
            {
                "_id":"11cf8d44fde98bd003b3cd22d0",
                "content":"用户：test删除了集群jiapin-dev",
                "create_time":1560309983,
                "type":"0",
                "user_id":"5cf8d358de98bd004266321a",
                "receive_id":"5cf8d44fde98bd003b3cdc2d",
                "status":"0"
            },
        ]
    },
    "status": 200,
    "message": "",
    "st": 1558507267.5984659,
    "crt": 3.7542481422424316
}
```
## 测试要点
1 消息过期    
2 消息过期后自动清除    
3 用户组和单个用户接收消息    
