
#import "EditViewController.h"
#import "ContactModel.h"
@interface EditViewController ()
@property (weak, nonatomic) IBOutlet UITextField *nameField;
@property (weak, nonatomic) IBOutlet UITextField *phoneField;
@property (weak, nonatomic) IBOutlet UITextField *qqField;
@property (weak, nonatomic) IBOutlet UIButton *saveBtn;
- (IBAction)saveAction:(id)sender;
@property (weak, nonatomic) IBOutlet UIBarButtonItem *edit;
- (IBAction)editAction:(UIBarButtonItem *)sender;
//以上为编辑页面中的连线
@end

@implementation EditViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    self.nameField.text = self.contactModel.name;
    self.phoneField.text = self.contactModel.phone;
    self.qqField.text = self.contactModel.qq;

    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.nameField];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.phoneField];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.qqField];
}
-(void)textChange{
    self.saveBtn.enabled = self.nameField.text.length && (self.phoneField.text.length || self.qqField.text.length);
     }
//添加观察者，实现控制按钮的enabled状态；

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

- (IBAction)saveAction:(id)sender {
  [self.navigationController popViewControllerAnimated:YES];
//1.关闭当前页面
  if ([self.delegate respondsToSelector:@selector(enditViewController:didSaveContact:)]) {
        self.contactModel.name = self.nameField.text;
        self.contactModel.phone = self.phoneField.text;
        self.contactModel.qq = self.qqField.text;
        [self.delegate enditViewController:self didSaveContact:self.contactModel];
//2.如果代理响应了协议方法,就更新数据模型
    }

}
//编辑响应方法
- (IBAction)editAction:(UIBarButtonItem *)sender {
    if (self.nameField.enabled) {
        self.nameField.enabled = NO;
        self.phoneField.enabled = NO;
        self.qqField.enabled = NO;
        [self.view endEditing:YES];
        self.saveBtn.hidden = YES;
        sender.title = @"编辑";
        //还原回原来的数据
        self.nameField.text = self.contactModel.name;
        self.phoneField.text = self.contactModel.phone;
        self.qqField.text = self.contactModel.qq;
    }else{
        self.nameField.enabled = YES;
        self.phoneField.enabled = YES;
        self.qqField.enabled = YES;
        [self.view endEditing:YES];
        self.saveBtn.hidden = NO;
        sender.title = @"取消";
    }
}
@end
