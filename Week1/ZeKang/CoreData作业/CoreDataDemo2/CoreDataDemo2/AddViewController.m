

#import "AddViewController.h"
#import "ContactModel.h"
@interface AddViewController ()
@property (weak, nonatomic) IBOutlet UITextField *nameField;
@property (weak, nonatomic) IBOutlet UITextField *phoneFiled;
@property (weak, nonatomic) IBOutlet UITextField *qqField;
@property (weak, nonatomic) IBOutlet UIButton *addBtn;
- (IBAction)addAction:(id)sender;

@end

@implementation AddViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    [[NSNotificationCenter defaultCenter]addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.nameField];
    [[NSNotificationCenter defaultCenter]addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.qqField];
    [[NSNotificationCenter defaultCenter]addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.phoneFiled];
}

- (void)textChange{
    self.addBtn.enabled = self.nameField.text && (self.phoneFiled.text || self.qqField);
}
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








- (IBAction)addAction:(id)sender {
    //关闭视图控制器
    [self.navigationController popViewControllerAnimated:YES];
    
    
    
    //代理传值
    if ([self.delegate respondsToSelector:@selector(addContact:didAddContact:)]) {
        ContactModel *contactModel = [[ContactModel alloc] init];
        contactModel.name = self.nameField.text;
        contactModel.phone = self.phoneFiled.text;
        contactModel.qq = self.qqField.text;
        [self.delegate addContact:self didAddContact:contactModel];}
}


@end
