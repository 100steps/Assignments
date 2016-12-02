//
//  ViewController.m
//  NetworkRequests
//
//  Created by apple on 2016/12/2.
//  Copyright © 2016年 modouhe. All rights reserved.
//

#import "ViewController.h"

@interface ViewController ()

@end

@implementation ViewController






- (void)viewDidLoad {
    [super viewDidLoad];
   
    //协议头+主机地址+接口名称+？+参数1&参数2&参数3
    //get请求 参数放在url后以？隔开 参数与参数之间用&连接
    //JSON(JavaScript Object Notation) 是一种轻量级的数据交换格式。JSON采用完全独立于语言的文本格式
    //JSON 可以将 JavaScript 对象中表示的一组数据转换为字符串，然后就可以在函数之间轻松地传递这个字符串，或者在异步应用程序中将字符串从 Web 客户机传递给服务器端程序

    //1.确定请求路径
    NSURL *url = [NSURL URLWithString:@"http://cityuit.sinaapp.com/1.php"];
    
    //2.创建请求对象
    //请求对象内部默认已经包含了请求头和请求方法（GET）
    NSURLRequest *req = [NSURLRequest requestWithURL:url];
    
    //3.获得会话对象
    NSURLSession *session = [NSURLSession sharedSession];
    
    //4.根据会话对象创建一个Task(发送请求）
    // 该方法内部会自动将请求路径包装成一个请求对象，该请求对象默认包含了请求头信息和请求方法（GET） 用post请求不能用此方法
    
    /*
     第一个参数：请求对象
     第二个参数：completionHandler回调（请求完成【成功|失败】的回调）
     data：响应体信息（期望的数据）
     response：响应头信息，主要是对服务器端的描述
     error：错误信息，如果请求失败，则error有值*/
    /*  dataTaskWithRequest  创建一个shuju create a data task to retrieve the contents of the given URL. */
    
    NSURLSessionDataTask *task = [session dataTaskWithRequest:req completionHandler:^(NSData * _Nullable data, NSURLResponse * _Nullable response, NSError * _Nullable error) {
        if(error == nil){
            
            //6.解析服务器返回的数据(返回的数据是JSON格式)
            //解析json的步骤大概是，先把json字符串读取到缓冲区，然后使用NSJSONSerialization    里面的方法进行解析
            
            NSDictionary *dict = [NSJSONSerialization JSONObjectWithData:data options:kNilOptions error:nil];
            NSLog(@"%@",dict);
        }
    } ];
    
    //7.执行任务
    [task resume];
    
    
    
    // Do any additional setup after loading the view, typically from a nib.
}


- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


@end
