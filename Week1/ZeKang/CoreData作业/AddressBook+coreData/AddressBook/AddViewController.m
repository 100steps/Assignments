

#import "AddViewController.h"
#import "ContactModel.h"
#import "Person+CoreDataProperties.h"
#import "AppDelegate.h"
@interface AddViewController ()<UITableViewDelegate,UITableViewDataSource>
- (IBAction)backAction:(id)sender;
@property (weak, nonatomic) IBOutlet UITextField *nameField;

@property (weak, nonatomic) IBOutlet UITextField *phoneField;

@property (weak, nonatomic) IBOutlet UITextField *qqField;

@property (weak, nonatomic) IBOutlet UIButton *addBtn;
- (IBAction)addAction;
@property (weak, nonatomic) IBOutlet UITableView *tableView;
@property (nonatomic,strong)AppDelegate *myAppDelegate;
@property (nonatomic,strong)NSMutableArray *dataSource;
@end

@implementation AddViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    
    self.dataSource = [NSMutableArray array];
    self.myAppDelegate = [UIApplication sharedApplication].delegate;
    
    
    
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.nameField];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.phoneField];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:UITextFieldTextDidChangeNotification object:self.qqField];
//添加3个观察者

}
- (void)textChange{
    self.addBtn.enabled = self.nameField.text.length && (self.phoneField.text.length || self.qqField.text.length);
}
//考虑到并不是每个人都同时有qq和phone，所以两者同或就可以激活addBtn

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}



//添加数据
- (IBAction)addAction {
    [self.navigationController popViewControllerAnimated:YES];
//关闭当前视图的控制器
    
    //代理传值
//    if ([self.delegate respondsToSelector:@selector(addContact:didAddContact:)]) {
        ContactModel *contactModel = [[ContactModel alloc] init];
        contactModel.name = self.nameField.text;
        contactModel.phone = self.phoneField.text;
        contactModel.qq = self.qqField.text;
        
        
        //插入数据
        
        //创建实体描述对象
        NSEntityDescription *description = [NSEntityDescription entityForName:@"Person" inManagedObjectContext:self.myAppDelegate.managedObjectContext];
        
        
        //1.先创建一个模型对象
        Person *person = [[Person alloc]initWithEntity:description insertIntoManagedObjectContext:self.myAppDelegate.managedObjectContext];
        
        
        
        person.name = contactModel.name;
        person.qq = contactModel.qq;
        person.phone = contactModel.phone;
        //插入数据源数组
        [self.dataSource addObject:person];
        
        
        [self.tableView insertRowsAtIndexPaths:@[[NSIndexPath indexPathForRow:self.dataSource.count inSection:0]] withRowAnimation:UITableViewRowAnimationLeft];
        
        [self.myAppDelegate saveContext];
        
        
//        [self.delegate addContact:self didAddContact:contactModel];
//    }
    
    
    
    }

#pragma mark - tableView的delegate 和 dataSource方法
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return self.dataSource.count;
}

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView{
    return 1;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"mycell" forIndexPath:indexPath];
    
//    Clothes *cloth = self.dataSource[indexPath.row];
//    cell.textLabel.text = [NSString stringWithFormat:@"%@--%@",cloth.name,cloth.price];
    return cell;
}
//- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath{
//    return YES;






//如果它的代理对象响应了协议方法，就就行传值


- (IBAction)backAction:(id)sender {
}
@end
