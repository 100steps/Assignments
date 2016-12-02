#import "LoginViewController.h"
#define UserNameKey @"name"
//设置用户名的关键字为“name”
@interface LoginViewController ()
@property (weak, nonatomic) IBOutlet UITextField *nameField;

@property (weak, nonatomic) IBOutlet UIButton *LoginBtn;

- (IBAction)LoginAction;

//以上是登陆界面的用户名框，登陆按钮的outlet和action连线

@end

@implementation LoginViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.nameField];
//添加一个用户名框的文本观察者，观察框内文本变化
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    self.nameField.text = [defaults valueForKey:UserNameKey];
    self.LoginBtn.enabled = YES;
    //读取上次的配置
    //用用户偏好设置的方法存储用户名。
}

- (void)textChange{
    self.LoginBtn.enabled = self.nameField.text.length;
}
//当用户名框文本为非空时，登陆按钮可用.



- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];

}


#pragma mark - Navigation
//使用它提供的"跳转前的准备"

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    UIViewController *contactVc = segue.destinationViewController;
    //第一步，取得目标视图控制器
    contactVc.title = [NSString stringWithFormat:@"%@的联系人列表",self.nameField.text];
    /*第二步，进行传值，使得title显示
    输入的用户名＋的联系人列表*/
}


- (IBAction)LoginAction {
    [self performSegueWithIdentifier:@"LoginToConnect" sender:nil];
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
   [defaults setObject:self.nameField.text forKey:UserNameKey];
//在登陆的时候储存用户名信息
    
   [defaults synchronize];
//设置同步

}

@end
