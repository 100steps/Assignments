

#import "ViewController.h"

@interface ViewController ()
@property (strong, nonatomic) IBOutlet UITextView *WeatherView;
@property (strong, nonatomic) IBOutlet UITextField *cityName;
//声明一个属性data1，用来储存从借口那里获取的data
@property (strong, nonatomic) NSData *data1;
- (IBAction)goBtn:(id)sender;

@end

@implementation ViewController

- (void)viewDidLoad {
    [super viewDidLoad];
}
- (void)setHttpArg:(NSString *)httpArg{

    //根据接口文档，编辑接口路径和查询条件，并拼接成一个完整的url，确定要访问的资源
    NSString *httpUrl = @"http://apis.baidu.com/heweather/weather/free";
    NSString *urlStr = [[NSString alloc]initWithFormat: @"%@?city=%@", httpUrl, httpArg];
    NSURL *url = [NSURL URLWithString: urlStr];
    //实例化一个Request对象，设置它的请求方法为：get，添加请求头值为我在百度免费apistore里的key，所以HeaderField为“apikey”
    NSMutableURLRequest *request = [[NSMutableURLRequest alloc]initWithURL: url cachePolicy: NSURLRequestUseProtocolCachePolicy timeoutInterval: 10];
    [request setHTTPMethod: @"GET"];
    [request addValue: @"6b72c54ca2833d3f71621a11f40b463e" forHTTPHeaderField: @"apikey"];
    //可怜的connection方法已经被弃用，所以用session方法，实例化一个会话对象，用会话对象来启动一个dataTask，并将获得的data数据传入到属性data1中。
    NSURLSession *session = [NSURLSession sharedSession];
    NSURLSessionDataTask *dataTask = [session dataTaskWithRequest:request completionHandler:^(NSData * _Nullable data, NSURLResponse * _Nullable response, NSError * _Nullable error) {
        _data1 = data;
    }];
    [dataTask resume];
    //一下一大片都是对所得的data进行解析并呈现，没特别多的技术含量。
    NSString *jsonString = [[NSString alloc]initWithData:_data1 encoding:NSUTF8StringEncoding];
    NSData *jsonData = [jsonString dataUsingEncoding:NSUTF8StringEncoding];
    id jsonArrOrDic = [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingAllowFragments error:nil];
    if ([jsonArrOrDic isKindOfClass:[NSDictionary class]]) {
        NSDictionary *jsonDic = (NSDictionary *)jsonArrOrDic;
        NSArray *jsonArr2 = [jsonDic objectForKey:@"HeWeather data service 3.0"];
        for (NSDictionary *jsonDic2 in jsonArr2) {
            NSArray *jsonArr3 = [jsonDic2 objectForKey:@"daily_forecast"];
            for (NSDictionary *jsonWeather in jsonArr3) {
                _WeatherView.text = [_WeatherView.text stringByAppendingString:@"\n"];
                _WeatherView.text = [_WeatherView.text stringByAppendingFormat:@"date:  %@",[jsonWeather objectForKey:@"date"]];
                NSDictionary *jsonDic4 = [jsonWeather objectForKey:@"astro"];
                _WeatherView.text = [_WeatherView.text stringByAppendingString:@"\n"];
                _WeatherView.text = [_WeatherView.text stringByAppendingFormat:@"sunrise:   %@",[jsonDic4 objectForKey:@"sr"]];
                _WeatherView.text = [_WeatherView.text stringByAppendingString:@"\n"];
                _WeatherView.text = [_WeatherView.text stringByAppendingFormat:@"sunset:   %@",[jsonDic4 objectForKey:@"ss"]];
                NSDictionary *jsonCond = [jsonWeather objectForKey:@"cond"];
                _WeatherView.text = [_WeatherView.text stringByAppendingString:@"\n"];
                _WeatherView.text =[ _WeatherView.text stringByAppendingFormat:@"DayWeather:     %@", [jsonCond objectForKey:@"txt_d"]];
                _WeatherView.text = [_WeatherView.text stringByAppendingString:@"\n"];
                _WeatherView.text =[ _WeatherView.text stringByAppendingFormat:@"NightWeather:     %@", [jsonCond objectForKey:@"txt_n"]];
                NSDictionary *jsontmp = [jsonWeather objectForKey:@"tmp"];
                _WeatherView.text = [_WeatherView.text stringByAppendingString:@"\n"];
                _WeatherView.text =[ _WeatherView.text stringByAppendingFormat:@"MaxTemp:     %@", [jsontmp objectForKey:@"max"]];
                _WeatherView.text = [_WeatherView.text stringByAppendingString:@"\n"];
                _WeatherView.text =[ _WeatherView.text stringByAppendingFormat:@"MinTemp:     %@", [jsontmp objectForKey:@"min"]];
                
            }
            
        }
        
        
    }
    
    
    
    
}






- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


- (IBAction)goBtn:(id)sender {
    //按下go按钮，可以触发该方法，该方法的目的就是将城市文本框里的字符串抓取，拼接到接口名称后边，即“？”后边，作为查询条件。
        [self setHttpArg:_cityName.text];
    
}
@end
